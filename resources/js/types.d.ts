interface Window {
    $: any;
    jQuery: any;
    flatpickr: any;
    initOwlCarousels: () => void;
}

declare module 'jquery';
declare module 'owl.carousel';
declare module 'flatpickr';