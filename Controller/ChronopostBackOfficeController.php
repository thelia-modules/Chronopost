<?php

namespace Chronopost\Controller;


use Chronopost\Chronopost;
use Chronopost\Config\ChronopostConst;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Translation\Translator;

class ChronopostBackOfficeController extends BaseAdminController
{
    /**
     * Render the module config page
     *
     * @return \Thelia\Core\HttpFoundation\Response
     */
    public function viewAction($tab)
    {
        return $this->render(
            'module-configure',
            [
                'module_code' => 'Chronopost',
                'current_tab' => $tab,
            ]
        );
    }

    public function saveLabel()
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], 'Chronopost', AccessManager::UPDATE)) {
            return $response;
        }

        $labelNbr = $this->getRequest()->get("labelNbr");
        $labelDir = $this->getRequest()->get("labelDir");

        $file = $labelDir . $labelNbr;
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
        } else {
            return $this->viewAction('export');
            // todo : Error message
        }

        return $this->generateSuccessRedirect();
    }

    /**
     * Save configuration form - Chronopost informations
     *
     * @return mixed|null|\Symfony\Component\HttpFoundation\Response|\Thelia\Core\HttpFoundation\Response
     */
    public function saveAction()
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], 'Chronopost', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm("chronopost_configuration_form");

        try {
            $data = $this->validateForm($form)->getData();

            /** Basic informations */
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_CODE_CLIENT, $data[ChronopostConst::CHRONOPOST_CODE_CLIENT]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_CODE_CLIENT_RELAIS, $data[ChronopostConst::CHRONOPOST_CODE_CLIENT_RELAIS]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_LABEL_DIR, $data[ChronopostConst::CHRONOPOST_LABEL_DIR]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_LABEL_TYPE, $data[ChronopostConst::CHRONOPOST_LABEL_TYPE]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_PASSWORD, $data[ChronopostConst::CHRONOPOST_PASSWORD]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_TREATMENT_STATUS, $data[ChronopostConst::CHRONOPOST_TREATMENT_STATUS]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_PRINT_AS_CUSTOMER_STATUS, $data[ChronopostConst::CHRONOPOST_PRINT_AS_CUSTOMER_STATUS]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_EXPIRATION_DATE, $data[ChronopostConst::CHRONOPOST_EXPIRATION_DATE]);

            /** Delivery types */
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_FRESH_DELIVERY_13_STATUS, $data[ChronopostConst::CHRONOPOST_FRESH_DELIVERY_13_STATUS]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_13_STATUS, $data[ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_13_STATUS]);
            /** @TODO Add other delivery types here */

        } catch (\Exception $e) {
            $this->setupFormErrorContext(
                Translator::getInstance()->trans(
                    "Error",
                    [],
                    Chronopost::DOMAIN_NAME
                ),
                $e->getMessage(),
                $form
            );

            return $this->viewAction('configure');
        }

        return $this->generateSuccessRedirect($form);
    }

    /**
     * Save configuration form - Shipper informations
     *
     * @return mixed|null|\Symfony\Component\HttpFoundation\Response|\Thelia\Core\HttpFoundation\Response
     */
    public function saveActionShipper()
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], 'Chronopost', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm("chronopost_configuration_form");

        try {
            $data = $this->validateForm($form)->getData();

            /** Shipper informations */
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_SHIPPER_NAME1, $data[ChronopostConst::CHRONOPOST_SHIPPER_NAME1]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_SHIPPER_NAME2, $data[ChronopostConst::CHRONOPOST_SHIPPER_NAME2]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_SHIPPER_ADDRESS1, $data[ChronopostConst::CHRONOPOST_SHIPPER_ADDRESS1]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_SHIPPER_ADDRESS2, $data[ChronopostConst::CHRONOPOST_SHIPPER_ADDRESS2]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_SHIPPER_COUNTRY, $data[ChronopostConst::CHRONOPOST_SHIPPER_COUNTRY]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_SHIPPER_CITY, $data[ChronopostConst::CHRONOPOST_SHIPPER_CITY]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_SHIPPER_ZIP, $data[ChronopostConst::CHRONOPOST_SHIPPER_ZIP]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_SHIPPER_CIVILITY, $data[ChronopostConst::CHRONOPOST_SHIPPER_CIVILITY]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_SHIPPER_CONTACT_NAME, $data[ChronopostConst::CHRONOPOST_SHIPPER_CONTACT_NAME]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_SHIPPER_PHONE, $data[ChronopostConst::CHRONOPOST_SHIPPER_PHONE]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_SHIPPER_MOBILE_PHONE, $data[ChronopostConst::CHRONOPOST_SHIPPER_MOBILE_PHONE]);
            Chronopost::setConfigValue(ChronopostConst::CHRONOPOST_SHIPPER_MAIL, $data[ChronopostConst::CHRONOPOST_SHIPPER_MAIL]);

        } catch (\Exception $e) {
            $this->setupFormErrorContext(
                Translator::getInstance()->trans(
                    "Error",
                    [],
                    Chronopost::DOMAIN_NAME
                ),
                $e->getMessage(),
                $form
            );

            return $this->viewAction('configure');
        }

        return $this->generateSuccessRedirect($form);
    }
}