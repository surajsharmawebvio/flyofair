import $ from 'jquery';
import 'bootstrap';
import 'owl.carousel';
import 'flatpickr';

// Make jQuery available globally
declare global {
    interface Window {
        $: typeof $;
        jQuery: typeof $;
    }
}

window.$ = window.jQuery = $;

export { $ };