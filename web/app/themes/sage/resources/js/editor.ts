import domReady from '@wordpress/dom-ready';
import { hideServicesPageMetaBox } from './UI/MetaBoxFilters';

domReady(() => {
  hideServicesPageMetaBox('#services_page_options');
});
