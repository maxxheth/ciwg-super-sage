import { $ } from 'zx';
import fs from 'node:fs/promises';
import { BladeDocument } from "stillat-blade-parser/src/document/bladeDocument";
import { BladeError, ErrrorLevel } from 'stillat-blade-parser/src/errors/bladeError';
import { DirectiveNode } from 'stillat-blade-parser/src/nodes/nodes';

// Helper utility to generate an error for an unmatched opening directive (if or hasSection)
function packUnmatchedOpeningError(directive: string, node: DirectiveNode): BladeError {
  const error = new BladeError();
  error.errorCode = directive === 'hasSection' ? 'blade.lint.unmatchedHasSection' : 'blade.lint.unmatchedIf';
  error.level = ErrrorLevel.Error;
  error.message =
    directive === 'hasSection'
      ? 'Unmatched @hasSection directive found without a corresponding @endif directive.'
      : 'Unmatched @if directive found without a corresponding @endif directive.';
  error.node = node;
  return error;
}

// Helper utility to generate an error for an unmatched @endif directive.
function packUnmatchedEndIfError(node: DirectiveNode): BladeError {
  const error = new BladeError();
  error.errorCode = 'blade.lint.unmatchedEndIf';
  error.level = ErrrorLevel.Error;
  error.message =
    'Unmatched @endif directive found without a corresponding @if or @hasSection directive.';
  error.node = node;
  return error;
}

// Check the sequential pairing of @if, @hasSection and @endif directives using a stack.
function checkForDirectiveMismatches(bladeDocNodes: any[]): BladeError[] {
  const errors: BladeError[] = [];
  // the stack holds objects with:
  //   directiveName – either 'if' or 'hasSection'
  //   node – the Puppet node itself, useful for error reporting.
  const stack: { directiveName: string; node: DirectiveNode }[] = [];

  for (const node of bladeDocNodes) {
    if (node instanceof DirectiveNode) {
      const dName = node.directiveName;

      if (dName === 'if' || dName === 'hasSection') {
        stack.push({ directiveName: dName, node });
      } else if (dName === 'endif') {
        // If there's no opening directive, then @endif is unmatched.
        if (stack.length === 0) {
          errors.push(packUnmatchedEndIfError(node));
        } else {
          // Pop the most recent opening. We assume that any opening (@if or @hasSection) can be paired with the next @endif.
          stack.pop();
        }
      }
      // You could add more conditions here if you need to check other directive mixes.
    }
  }

  // Any remaining items in the stack are unmatched.
  for (const unclosed of stack) {
    errors.push(packUnmatchedOpeningError(unclosed.directiveName, unclosed.node));
  }

  return errors;
}

// Define the linting logic for a single Blade file
async function lintBladeFile(filePath: string) {
  const content = await fs.readFile(filePath, 'utf-8');
  const bladeDoc = BladeDocument.fromText(content);

  // Start with any errors detected by the parser.
  const errors = bladeDoc.errors.all();

  // Get all nodes in the document.
  const bladeDocNodes = bladeDoc.getAllNodes();

  // Run our custom matcher for @if, @hasSection and @endif.
  const customErrors = checkForDirectiveMismatches(bladeDocNodes);

  // Combine errors from the parser and from our custom check.
  const allErrors = [...errors, ...customErrors];


  if (allErrors.length > 0) {
    console.log(`\nLinting errors in ${filePath}:`);
    for (const error of allErrors) {
      const level = error.level === ErrrorLevel.Error ? 'Error' : 'Warning';
      console.error(
        `${level} [${error.errorCode}] at ${error?.node?.startPosition?.line ?? 'unknown'}:${error.node?.startPosition?.index ?? 'unknown'} - ${error.message}`
      );

      // Write error details to a log file (optional)

      fs.mkdir('log', { recursive: false });
      fs.appendFile('log/lint-errors.log', `${level} [${error.errorCode}] at ${error?.node?.startPosition?.line ?? 'unknown'}:${error.node?.startPosition?.index ?? 'unknown'} - ${error.message}\n`);
    }
  } else {
    console.log(`No issues found in ${filePath}`);
  }
}

(async () => {
  // Use the `find` utility to get all *.blade.php files
  const files = (await $`find . -name "*.blade.php"`).stdout.trim().split('\n');

  // Process each Blade file
  for (const file of files) {
    if (!file) continue; // Skip empty lines
    await lintBladeFile(file);
  }
})();
