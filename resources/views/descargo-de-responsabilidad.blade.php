@extends('app')

@section('title', 'FlyOFair | Descargo de Responsabilidad')

@section('meta')
    <meta name="description" content="El Descargo de Responsabilidad de FlyOFair explica que puedes comprar billetes de avión de socios de confianza con asistencia completa." />
    <link rel="canonical" href="https://www.flyofair.com/es/descargo-de-responsabilidad/" />
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
@endpush

@section('content')
    <section class="innerbanner-section">
        <div class="innerbannerbg">
            <img src="{{ asset('images/banner/author-banner.jpg') }}" alt="">
        </div>
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-10 col-12">
                    <div class="inner-bannerbox">
                        <h1 class="innercommon-heading">Descargo De Responsabilidad</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="common-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="innerdefaultpage-contentbox">
                        <p>FlyOFair («Empresa», «nosotros», «nuestro», «nos») le ayuda a buscar y reservar vuelos y paquetes relacionados. No somos propietarios ni tenemos ninguna alianza con ninguna aerolínea ni sus filiales. Por lo tanto, todas las reservas se realizan directamente entre usted y dichos proveedores de servicios. Le recomendamos que lo lea atentamente antes de reservar o utilizar nuestro sitio web.</p>

                        <h2>Errores y omisiones</h2>

                        <p>Hacemos todo lo posible por proporcionar la información más precisa y actualizada. Sin embargo, le informamos de que los detalles como los precios, los horarios de los vuelos, la disponibilidad de asientos u otras políticas cambian constantemente. La información puede cambiar sin previo aviso, y FlyOFair no se hace responsable de los errores, cancelaciones, retrasos o cambios realizados por las aerolíneas o los socios de viaje.</p>

                        <h3>Responsabilidad</h3>

                        <p>Los precios pueden variar en función de la disponibilidad, y todos los precios que aparecen en nuestro sitio web son proporcionados por nuestros proveedores. Pueden aplicarse impuestos y cargos adicionales. Se pueden aplicar recargos al precio. Por ejemplo, puede haber un cargo por equipaje o un cargo por servicio.</p>

                        <p>FlyOFair no se hace responsable de ninguna pérdida, lesión o daño que resulte de retrasos, cancelaciones, condiciones meteorológicas u otras condiciones que escapen a nuestro control. Es responsabilidad del pasajero comprobar los requisitos de visado, las restricciones de viaje y las condiciones de salud o seguridad antes de la salida.</p>

                        <h3>Condiciones de garantía</h3>

                        <p>Al utilizar FlyOFair, usted acepta que no nos hacemos responsables de ninguna pérdida o daño que se derive del uso de nuestro sitio web o nuestros servicios. Le recomendamos que revise cuidadosamente todos los detalles de la reserva antes de confirmar su viaje. Si tiene alguna pregunta o necesita ayuda con su reserva, póngase en contacto con nuestro equipo de atención al cliente antes de completar su compra.</p>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection