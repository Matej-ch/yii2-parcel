document.addEventListener('DOMContentLoaded',() => {
    document.querySelector('body #modalGlobal #send-to-parcel').addEventListener('mouseover', (e) => {
        let weight = 0;
        document.querySelectorAll('body #modalGlobal .package-weight').forEach(function(element) {
            weight += parseFloat(element.value);
        });

        if(weight != parseFloat('$weight')) {
            e.target.setAttribute('disabled','disabled');
            document.getElementById('send-to-parcel-msg').innerText = 'Váha balíkov ' + weight + ' sa nezhoduje z váhou objednávky '+'$weight';
        } else {
            e.target.removeAttribute('disabled');
            document.getElementById('send-to-parcel-msg').innerText = '';
        }
    });

    document.getElementById('parcel-map-dropdown').addEventListener('change', e => {
        let url = e.target.dataset.url + e.target.value +
            '&address=' + document.getElementById('pickup-address-dropdown').value +
            '&modelID='+document.getElementById('modelID').value;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if(data['success'] === true) {
                    document.querySelectorAll('.map-inputs').forEach(function(element) {
                        element.value = '';
                    });

                    for(const key of Object.keys(data['values'])) {
                        if(key === 'webservicepackage-reffnr') {
                            document.querySelectorAll('.package-reffnr').forEach(function(el) {
                                el.value =  data['values'][key];
                            });
                        } else if(key === 'webservicepackage-weight') {
                            document.querySelectorAll('.package-weight').forEach(function(el) {
                                el.value =  data['values'][key];
                            });
                        } else {
                            if(document.getElementById(key)) {
                                document.getElementById(key).value = data['values'][key];
                            }
                        }
                    }


                }
            })
            .catch(err => console.error('Error: ' + err));
    });

    document.getElementById('pickup-address-dropdown').addEventListener('change', e=> {
        let url = e.target.dataset.url + '&address=' + e.target.value;
        fetch(url).then(res => res.json()).then(data => {
            if(data['success'] === true) {
                for (let key of Object.keys(data['values'])) {
                    if(document.getElementById("pickupaddress-"+key)) {
                        document.getElementById("pickupaddress-"+key).value = '';
                        document.getElementById("pickupaddress-"+key).value = data['values'][key];
                    }
                }
            }

        }).catch(err => console.error('Error: ' + err));
    });

    document.getElementById('account-dropdown').addEventListener('change', e => {

        document.querySelector('#create-parcel-shipment #send-to-parcel').innerText = "$btnMsg " +e.target.options[e.target.selectedIndex].text;
    });

    document.getElementById('PackageCount').addEventListener('change', e => {
        let value = parseInt(e.target.value);

        const divNode = document.getElementById("packageWrapper");
        while (divNode.firstChild) {
            divNode.removeChild(divNode.firstChild);
        }

        createPackages(value);
    });

    document.querySelectorAll('.packageNumBtn').forEach(function(element, index) {
        element.addEventListener('click',(e) => {
            e.preventDefault();
            let value = parseInt(e.target.getAttribute('data-val'));
            document.getElementById('PackageCount').value = value;

            const divNode = document.getElementById("packageWrapper");
            while (divNode.firstChild) {
                divNode.removeChild(divNode.firstChild);
            }

            createPackages(value);
        });
    });

    function createPackages(numOfPackages) {
        for (let i=2; i <= numOfPackages; i++) {
            let tmpl = document.getElementById('package-form-template').content.cloneNode(true);

            let reffNrEl = tmpl.getElementById('webservicepackage-reffnr');
            let reffNrWrapperEl = tmpl.querySelector('.field-webservicepackage-reffnr');

            let weightEl = tmpl.getElementById('webservicepackage-weight');
            let weightWrapperEl =  tmpl.querySelector('.field-webservicepackage-weight');

            reffNrEl.value = document.querySelector('.form-wrapper #webservicepackage-reffnr-1').value;
            reffNrEl.setAttribute('name','shipment[WebServicePackage][' + i + '][reffnr]');
            reffNrEl.id = 'webservicepackage-reffnr-' + i;
            reffNrWrapperEl.classList.remove('field-webservicepackage-reffnr');
            reffNrWrapperEl.classList.add('field-webservicepackage-reffnr-' + i);

            weightEl.setAttribute('name','shipment[WebServicePackage][' + i + '][weight]');
            weightEl.id='webservicepackage-weight-' + i;
            weightWrapperEl.classList.remove('field-webservicepackage-weight');
            weightWrapperEl.classList.add('field-webservicepackage-weight-' + i);

            document.getElementById('packageWrapper').append(tmpl);

            $('#create-parcel-shipment').yiiActiveForm('add', {
                id: 'webservicepackage-reffnr-' + i,
                name: 'shipment[WebServicePackage][' + i + '][reffnr]',
                container: '.field-webservicepackage-reffnr-' + i,
                input: '#webservicepackage-reffnr-' + i,
                error: '.help-block',
                validate:  function (attribute, value, messages, deferred, form) {
                    yii.validation.required(value, messages, {message: "Pole Referenčné číslo balíka nesmie byť prázdne."});
                }
            });

            $('#create-parcel-shipment').yiiActiveForm('add', {
                id: 'webservicepackage-weight-' + i,
                name: 'shipment[WebServicePackage][' + i + '][weight]',
                container: '.field-webservicepackage-weight-' + i,
                input: '#webservicepackage-weight-' + i,
                error: '.help-block',
                validate:  function (attribute, value, messages, deferred, form) {
                    yii.validation.required(value, messages, {message: "Pole Váha balíka (KG) nesmie byť prázdne."});
                }
            });
        }
    }

    document.querySelector('body').addEventListener('click',function (e) {
        if(e.target.classList.contains('remove-package')) {
            e.preventDefault();
            document.getElementById('PackageCount').value -= 1;

            e.target.closest('.well').querySelectorAll('input').forEach(function(element) {
                $('#create-parcel-shipment').yiiActiveForm('remove', element.id);
            });

            e.target.closest('.well').remove();
        }
    });
})