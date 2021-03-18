<?php

$metadata['http://localhost:8000/saml/metadata'] = array(
    'entityid' => 'http://localhost:8000/saml/metadata',
    'description' => array(
        'en' => 'Enabel',
    ),
    'OrganizationName' => array(
        'en' => 'Enabel',
    ),
    'name' => array(
        'en' => 'Enabel',
    ),
    'OrganizationDisplayName' => array(
        'en' => 'Enabel',
    ),
    'url' => array(
        'en' => 'http://enabel.be',
    ),
    'OrganizationURL' => array(
        'en' => 'http://enabel.be',
    ),
    'contacts' => array(
    ),
    'metadata-set' => 'saml20-sp-remote',
    'expire' => 15543170400,
    'AssertionConsumerService' => array(
        0 => array(
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
            'Location' => 'http://localhost:8000/saml/acs',
            'index' => 1,
        ),
    ),
    'SingleLogoutService' => array(
        0 => array(
            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
            'Location' => 'http://localhost:8000/saml/logout',
        ),
    ),
    'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
    'validate.authnrequest' => false,
    'saml20.sign.assertion' => false,
);
