<?php

return [
    'codvalue' => 'Cash on delivery value',
    'codretbankacc' => 'IBAN',
    'codretbankacc_hint' => 'Bank account number for COD',
    'codretbankcode' => 'SWIFT/BIC',
    'id' => 'ID',
    'username' => 'Username',
    'password' => 'Password',
    'title' => 'Slovak parcel api',
    'name' => 'Name',
    'default' => 'Default',
    'name_hint' => 'This is only used in your app, to differentiate between parcel accounts',
    'default_hint' => 'Only one can be default',
    'username_hint' => 'Login name for Slovak parcel API',
    'password_hint' => 'Login password for Slovak parcel API',
    'token_hint' => 'Token is received from Slovak parcel API',
    'pick_city' => 'Pickup city',
    'pick_contactPerson' => 'Contact person',
    'pick_country' => 'Pickup country ISO code',
    'pick_email' => 'Pickup email',
    'pick_mobile' => 'Pickup phone number',
    'pick_name' => 'Sender name',
    'pick_phone' => 'Pickup phone number',
    'pick_street' => 'Pickup street',
    'pick_zip' => 'Pickup zipcode',
    'pick_street_hint' => 'address + house number',
    'city_del' => 'Recipient city',
    'contactPerson_del' => 'Contact person',
    'country_del' => 'Country iso code',
    'email_del' => 'Recipient email',
    'mobile_del' => 'Recipient mobile phone',
    'name_del' => 'Recipient name',
    'phone_del' => 'Recipient phone number',
    'street_del' => 'Recipient street',
    'zip_del' => 'Recipient zipcode',
    'street_del_hint' => 'address + house number',
    'reffnr' => 'Package refference number',
    'weight' => 'Package weight (KG)',
    'pickupstartdatetime' => 'Pickup start date and time',
    'pickupenddatetime' => 'Pickup end date and time',
    'cod' => 'Cash on delivery',
    'insurvalue' => 'Shipment insurance value',
    'notifytype' => 'Receiver notification',
    'notifytype_hint' => '0 = disabled, 1 = email, 2 = sms, 3 = both email and sms',
    'productdesc' => 'Product description',
    'recipientpay' => 'Freight paid by recipient',
    'returnshipment' => 'Return shipment - document collect DC',
    'saturdayshipment' => 'Saturday delivery',
    'servicename' => 'Delivery service',
    'servicename_hint' => 'expres, 0900, 1200, export',
    'tel' => 'Tel before delivery(TEL)',
    'units' => 'Invoicing unit',
    'units_hint' => '"kg", "boxa","boxb", "boxc","winebox3","winebox6", "winebox12"',
    'packages' => 'Packages of the shipment',
    'pickupaddress' => 'Pickup address',
    'pickupaddress_hint' => 'Undefined means pickup at senders address',
    'deliveryaddress' => 'Delivery address',
    'shipmentpickup' => 'Date and time of shipment pickup',
    'codattribute' => 'Cash on delivery attribute',
    'codattribute_hint' => '0 = cash(default), 3 = VIAMO, 4 = Card payment',
    'deliverytype' => 'Delivery type',
    'deliverytype_hint' => '"2PT" - Parcel terminal, "2PS" - Parcelshop',
    'warnings_hint' => 'Error message. Data transfer failed if this message is not empty.',
    'errors_hint' => 'Warning messages. The import was successful with some warnings.',
    'refNr' => 'Reference number',
    'shipNr' => 'Package tracking number in CargoNet system',
    'packageNo' => 'Package order number',
    'codAttr' => 'codAttr',
    'appellation' => 'Appellation',
    'contactperson' => 'Contact person',
    'name1' => 'Company name',
    'name2' => 'name2',
    'name3' => 'name3',
    'name4' => 'name4',
    'name5' => 'name5',
    'name6' => 'name6',
    'zip' => 'ZIP',
    'city' => 'CITY',
    'notused' => 'notused',
    'street' => 'Street',
    'housenr' => 'House No.',
    'housenrext' => 'housenrext',
    'country' => 'ISO Country code',
    'phone' => 'Phone number',
    'email' => 'Email',
    'mobile' => 'Mobile phone number',
    'refnr1' => 'Ref. number of package',
    'refnr2' => '2. Ref. number',
    'refnr2_hint' => 'On the waybill: Receiver contact',
    'refnr3' => '3. Ref. number',
    'refnr3_hint' => 'On the waybill: shipper contact',
    'scannedbarcode' => 'Package number',
    'scannedbarcode_hint' => '* Required only if the barcode value on the waybill differs from "Ref. number of package" field',
    'cargo24h' => 'Cargo24h Positive number, Cargo ="70"',
    'cargoattr'=> 'Cargo attr Positive number, "00"',
    'consumer'=> 'Consumer address',
    'deliverydate'=> 'Delivery date DD.MM.YYYY',
    'deliverydate_hint' => 'Required if [Delivery Time from] or [Delivery time to] or [Delivery remark] is set',
    'deliveryremark'=> 'Delivery remark',
    'deliveryremark_hint' => '[Delivery date] is required if this field is set',
    'deliverytimefrom'=> 'Delivery time From, HH:MM',
    'deliverytimefrom_hint' => '[Delivery date] is required if this field is set',
    'deliverytimeto'=> 'Delivery time To, HH:MM',
    'deliverytimeto_hint' => '[Delivery date] is required if this field is set',
    'deliverytype_mip'=> 'Delivery mip type',
    'deliverytype_mip_hint' => '2B=empty or "-",2C ="+",2PT-BoxA = "1",2PT-BoxB = "2",2PT-BoxC = "3",2PS = "4"',
    'hypermarket'=> 'service HYM, 1 = true, 0= false',
    'insurcurr'=> 'Insurance currency',
    'insurcurr_hint' => '0 (or empty) = local / 1=Euro',
    'internalnrtype'=> 'Internal nr. type Example: "08"',
    'numberofeuropalettes'=> 'Number of euro palettes',
    'packages_mip'=> 'Array of MIP packages',
    'pdely'=> 'Receiver contact',
    'pdely_hint' => 'If empty, service PDELYwill be not applied.',
    'receiver'=> 'Receiver address',
    'receivernotifytype'=> 'Notification type',
    'receivernotifytype_hint'=> '0=no notification; Pr??zdne=none; 1=Mail; 2=SMS for service <SMSR> or <EMLR>; 3=both <SMSR> and <EMLR>',
    'recipientpay_hint'=> '1 = true, 0 = false',
    'returnshipment_hint'=> '1 = true, 0 = false',
    'saturdayattr'=> 'Saturday attr',
    'saturdayshipment_hint'=> '1 = true, 0 = false',
    'sender'=> 'Sender address',
    'shipdate'=> 'Shipping date DD.MM.YYYY',
    'shipdate_hint' => 'Current day will be used if empty',
    'shipinfo1'=> 'shipinfo1 - Printed on the waybill only',
    'shipinfo2'=> 'shipinfo2 - Printed on the waybill only',
    'shipinfo3'=> 'shipinfo3 - Printed on the waybill only',
    'shipinfo4'=> 'shipinfo4 - Printed on the waybill only',
    'numberofmippackages' => 'Number of mip packages',
    'numberofmipshipment' => 'Number of mip shipments',
    'shipmentresult' => 'Shipment result',
    'labelUrl' => 'Label url',
    'reportsUrl' => 'Report url',
    'errors' => 'Errors',
    'documentUrl' => 'Document url',
    'warnings' => 'Warnings',
    'type' => 'Type',
    'place_id' => 'Place id',
    'description' => 'Description',
    'address' => 'Address',
    'virtualzip' => 'Virtual zip',
    'countryISO' => 'Country code (ISO)',
    'status' => 'Status',
    'gps' => 'Gps',
    'center' => 'Center',
    'workDays' => 'Work days',
    'function' => 'Function',
    'data' => 'Data',
    'response' => 'Response',
    'model' => 'Model',
    'packageInfo' => 'Information about created packages of the shipment',
    'result' => 'Error and warning messages',
    'map' => 'Attributes map',
    'webServiceShipmentType' => 'Shipment type',
    'print_labels' => 'Print waybills',
    'order_shipment' => 'Pickup order',
    'disabled' => 'Disabled',
    'sms' => 'Sms',
    'both email and sms' => 'Both email and sms',
    'yes'=>'Yes',
    'no'=> 'No',
    'terminal' => 'Parcel terminal',
    'parcelshop' => 'Parcelshop',
    'local' => 'Local currency',
    'map_name' => 'Map name',
    'webServiceShipment' => 'Shipment parameters',
    'pickupAddress' => 'Pickup address',
    'pickupAddress_hint' => 'Undefined means pickup at senders address',
    'deliveryAddress' => 'Delivery address',
    'mipWebserviceShipment' => 'Mip format shipment',
    'webServicePackage' => 'Package',
    'default_map' => 'Default map',
    'handover_protocol_id' => 'Handover protocol',
    'is_active' => 'Je akt??vny',
    'created_at' => 'Vytvoren??',
    'valid' => 'Valid',
    'invalid' => 'Invalid',
    'prompt' => 'Choose...'
];
