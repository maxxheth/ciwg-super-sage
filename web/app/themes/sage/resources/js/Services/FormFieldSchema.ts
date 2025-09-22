/**
 * Form field validation schema
 */
export class FormFieldSchema {
  fieldName: string;
  schema: any;

  constructor(fieldName: string, schema: any) {
    this.fieldName = fieldName;
    this.schema = schema;
  }
}
