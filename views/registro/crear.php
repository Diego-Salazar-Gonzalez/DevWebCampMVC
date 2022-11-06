<main class="registro">
    <h2 class="registro__heading"><?php echo $titulo ?></h2>
    <p class="registro__descripcion">Elige tu plan</p>


    <div class="paquetes__grid">
        <div class="paquete">
            <h3 class="paquete__nombre">
                Pase Gratis
            </h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">
                    Acceso Virtual a DevWebCamp
                </li>

                <p class="paquete__precio">$0</p>

                <form method="POST" action="/finalizar-registro/gratis">
                    <input type="submit" class="paquetes__submit" value="Inscripcion Gratis">
                </form>


            </ul>
        </div>
        <div class="paquete">
            <h3 class="paquete__nombre">
                Pase Presencial
            </h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">
                    Acceso Presencial a DevWebCamp
                </li>
                <li class="paquete__elemento">
                    Pase por 2 dias
                </li>
                <li class="paquete__elemento">
                    Acceso a talleres y conferencias
                </li>
                <li class="paquete__elemento">
                    Acceso a las grabaciones
                </li>
                <li class="paquete__elemento">
                    Camisa del Evento
                </li>
                <li class="paquete__elemento">
                    Comida y Bebida
                </li>

                <p class="paquete__precio">$199</p>

                <div id="smart-button-container">
                    <div style="text-align: center;">
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
                <div id="smart-button-container">
                    <div style="text-align: center;">
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
            </ul>
        </div>

        <div class="paquete">
            <h3 class="paquete__nombre">
                Pase Virtual
            </h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">
                    Acceso Virtual a DevWebCamp
                </li>
                <li class="paquete__elemento">
                    Pase por 2 dias
                </li>
                <li class="paquete__elemento">
                    Acceso a las grabaciones
                </li>
                <li class="paquete__elemento">
                    Acceso a talleres y conferencias
                </li>

                <p class="paquete__precio">$49</p>

                <div id="smart-button-container">
                    <div style="text-align: center;">
                        <div id="paypal-button-container--virtual"></div>
                    </div>
                </div>
            </ul>
        </div>


    </div>
</main>



<script src="https://www.paypal.com/sdk/js?client-id=AT0okrLuS1H67NxFXvNpJ6mn6WgSXLAOz67JRFi2j24dGmfgGyhUXp132jeIaMpzJ5LNzlxF-TJ7LLUm&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
<script>
    function initPayPalButton() {
       
        paypal.Buttons({
            style: {
                shape: 'pill',
                color: 'blue',
                layout: 'vertical',
                label: 'pay',

            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        "description": "1",
                        "amount": {
                            "currency_code": "USD",
                            "value": 222.88,
                            "breakdown": {
                                "item_total": {
                                    "currency_code": "USD",
                                    "value": 199
                                },
                                "shipping": {
                                    "currency_code": "USD",
                                    "value": 0
                                },
                                "tax_total": {
                                    "currency_code": "USD",
                                    "value": 23.88
                                }
                            }
                        }
                    }]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {

                    const datos = new FormData();
                    
                    datos.append('paquete_id', orderData.purchase_units[0].description);
                    datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id);
                    console.log(orderData);
                    fetch('/finalizar-registro/pagar', {
                            method: 'POST',
                            body: datos
                        }).then(respuesta => respuesta.json())
                        .then(resultado => {
                            if (resultado.resultado) {
                               actions.redirect( window.location.href + '/conferencias')
                            }
                        })
                });
            },

            onError: function(err) {
                console.log(err);
            }
        }).render('#paypal-button-container');



        paypal.Buttons({
            style: {
                shape: 'pill',
                color: 'blue',
                layout: 'vertical',
                label: 'pay',

            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        "description": "2",
                        "amount": {
                            "currency_code": "USD",
                            "value": 55.86,
                            "breakdown": {
                                "item_total": {
                                    "currency_code": "USD",
                                    "value": 49
                                },
                                "shipping": {
                                    "currency_code": "USD",
                                    "value": 0
                                },
                                "tax_total": {
                                    "currency_code": "USD",
                                    "value": 6.86
                                }
                            }
                        }
                    }]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {

                    const datos = new FormData();
                    
                    datos.append('paquete_id', orderData.purchase_units[0].description);
                    datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id);
                    
                    fetch('/finalizar-registro/pagar', {
                            method: 'POST',
                            body: datos
                        }).then(respuesta => respuesta.json())
                        .then(resultado => {
                            if (resultado.resultado) {
                               
                                actions.redirect( window.location.href + '/conferencias')
                            }
                        })
                });
            },

            onError: function(err) {
                console.log(err);
            }
        }).render('#paypal-button-container--virtual');



    }
    initPayPalButton();
</script>