<?php

namespace Chronopost\Form;


use Chronopost\Config\ChronopostConst;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class ChronopostConfigurationForm extends BaseForm
{
    protected function buildForm()
    {
        $config = ChronopostConst::getConfig();

        $this->formBuilder

            /** Chronopost basic informations */
            ->add(
                ChronopostConst::CHRONOPOST_CODE_CLIENT,
                "text",
                [
                    'required'      => true,
                    'data'          => $config[ChronopostConst::CHRONOPOST_CODE_CLIENT],
                    'label'         => Translator::getInstance()->trans("Chronopost client ID"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("Your Chronopost client ID"),
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_CODE_CLIENT_RELAIS,
                "text",
                [
                    'required'      => false,
                    'data'          => $config[ChronopostConst::CHRONOPOST_CODE_CLIENT_RELAIS],
                    'label'         => Translator::getInstance()->trans("Chronopost relay client ID"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("Your Chronopost relay client ID"),
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_LABEL_DIR,
                "text",
                [
                    'required'      => true,
                    'data'          => $config[ChronopostConst::CHRONOPOST_LABEL_DIR],
                    'label'         => Translator::getInstance()->trans("Directory where to save Chronopost labels"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => THELIA_LOCAL_DIR . 'chronopost',
                    ],
                ]
            )

            ->add(ChronopostConst::CHRONOPOST_PASSWORD,
                "text",
                [
                    'required'      => true,
                    'data'          => $config[ChronopostConst::CHRONOPOST_PASSWORD],
                    'label'         => Translator::getInstance()->trans("Chronopost password"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("Your Chronopost password"),
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_TREATMENT_STATUS,
                "text",
                [
                    'required'      => true,
                    'data'          => $config[ChronopostConst::CHRONOPOST_TREATMENT_STATUS],
                    'label'         => Translator::getInstance()->trans("\"Processing\" order status ID"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("\"Processing\" order status ID"),
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_LABEL_TYPE,
                "choice",
                [
                    'required'      => true,
                    'data'          => $config[ChronopostConst::CHRONOPOST_LABEL_TYPE],
                    'label'         => Translator::getInstance()->trans("Label file type"),
                    'label_attr'    => [
                        'for'           => 'level_field',
                    ],
                    'choices'       => [
                        "PDF"           => "PDF label with proof of deposit laser printer",
                        "SPD"           => "PDF label without proof of deposit laser printer",
                        "THE"           => "PDF label without proof of deposit for thermal printer",
                        "Z2D"           => "ZPL label with proof of deposit for thermal printer",
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_PRINT_AS_CUSTOMER_STATUS,
                "choice",
                [
                    'required'      => true,
                    'data'          => $config[ChronopostConst::CHRONOPOST_PRINT_AS_CUSTOMER_STATUS],
                    'label'         => Translator::getInstance()->trans("For the sending address, use :"),
                    'label_attr'    => [
                        'for'           => 'level_field',
                    ],
                    'choices'       => [
                        "N"           => "The shipper's one (Default value)",
                        "Y"           => "The customer's one (Do not use without knowing what it is)",
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_EXPIRATION_DATE,
                "text",
                [
                    'required'      => false,
                    'data'          => $config[ChronopostConst::CHRONOPOST_EXPIRATION_DATE],
                    'label'         => Translator::getInstance()->trans("Number of days before expiration date from the moment the order is in \"Processing\" status"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("5"),
                    ],
                ]
            )


            /** Delivery types */
            ->add(ChronopostConst::CHRONOPOST_FRESH_DELIVERY_13_STATUS,
                "checkbox",
                [
                    'required'      => false,
                    'data'          => (bool) $config[ChronopostConst::CHRONOPOST_FRESH_DELIVERY_13_STATUS],
                    'label'         => Translator::getInstance()->trans("\"Fresh\" 13h Delivery (Code : 2R)"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_13_STATUS,
                "checkbox",
                [
                    'required'      => false,
                    'data'          => (bool) $config[ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_13_STATUS],
                    'label'         => Translator::getInstance()->trans("\"Chrono\" 13h Delivery (Code : 01)"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_18_STATUS,
                "checkbox",
                [
                    'required'      => false,
                    'data'          => (bool) $config[ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_18_STATUS],
                    'label'         => Translator::getInstance()->trans("\"Chrono\" 18h Delivery (Code : 16)"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_13_BAL_STATUS,
                "checkbox",
                [
                    'required'      => false,
                    'data'          => (bool) $config[ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_13_BAL_STATUS],
                    'label'         => Translator::getInstance()->trans("\"Chrono\" 13h Relay Delivery (Code : 56)"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_CLASSIC_STATUS,
                "checkbox",
                [
                    'required'      => false,
                    'data'          => (bool) $config[ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_CLASSIC_STATUS],
                    'label'         => Translator::getInstance()->trans("\"Chrono\" Europe Classic Delivery (Code : 44)"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_EXPRESS_STATUS,
                "checkbox",
                [
                    'required'      => false,
                    'data'          => (bool) $config[ChronopostConst::CHRONOPOST_DELIVERY_CHRONO_EXPRESS_STATUS],
                    'label'         => Translator::getInstance()->trans("\"Chrono\" Europe Express Delivery (Code : 17)"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                ]
            )
            /** @TODO Add other delivery types */

            /** Shipper Informations */
            ->add(ChronopostConst::CHRONOPOST_SHIPPER_NAME1,
                "text",
                [
                    'required'      => true,
                    'data'          => $config[ChronopostConst::CHRONOPOST_SHIPPER_NAME1],
                    'label'         => Translator::getInstance()->trans("Company name 1"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("Dupont & co")
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_SHIPPER_NAME2,
                "text",
                [
                    'required'      => false,
                    'data'          => $config[ChronopostConst::CHRONOPOST_SHIPPER_NAME2],
                    'label'         => Translator::getInstance()->trans("Company name 2"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("")
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_SHIPPER_ADDRESS1,
                "text",
                [
                    'required'      => true,
                    'data'          => $config[ChronopostConst::CHRONOPOST_SHIPPER_ADDRESS1],
                    'label'         => Translator::getInstance()->trans("Address 1"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("Les Gardelles")
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_SHIPPER_ADDRESS2,
                "text",
                [
                    'required'      => false,
                    'data'          => $config[ChronopostConst::CHRONOPOST_SHIPPER_ADDRESS2],
                    'label'         => Translator::getInstance()->trans("Address 2"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("Route de volvic")
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_SHIPPER_COUNTRY,
                "text",
                [
                    'required'      => true,
                    'data'          => $config[ChronopostConst::CHRONOPOST_SHIPPER_COUNTRY],
                    'label'         => Translator::getInstance()->trans("Country (ISO ALPHA-2 format)"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("FR")
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_SHIPPER_CITY,
                "text",
                [
                    'required'      => true,
                    'data'          => $config[ChronopostConst::CHRONOPOST_SHIPPER_CITY],
                    'label'         => Translator::getInstance()->trans("City"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("Paris")
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_SHIPPER_ZIP,
                "text",
                [
                    'required'      => true,
                    'data'          => $config[ChronopostConst::CHRONOPOST_SHIPPER_ZIP],
                    'label'         => Translator::getInstance()->trans("ZIP code"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("93000")
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_SHIPPER_CIVILITY,
                "text",
                [
                    'required'      => true,
                    'data'          => $config[ChronopostConst::CHRONOPOST_SHIPPER_CIVILITY],
                    'label'         => Translator::getInstance()->trans("Civility"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("E (Madam), L (Miss), M (Mister)")
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_SHIPPER_CONTACT_NAME,
                "text",
                [
                    'required'      => true,
                    'data'          => $config[ChronopostConst::CHRONOPOST_SHIPPER_CONTACT_NAME],
                    'label'         => Translator::getInstance()->trans("Contact name"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("Jean Dupont")
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_SHIPPER_PHONE,
                "text",
                [
                    'required'      => false,
                    'data'          => $config[ChronopostConst::CHRONOPOST_SHIPPER_PHONE],
                    'label'         => Translator::getInstance()->trans("Phone"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("0142080910")
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_SHIPPER_MOBILE_PHONE,
                "text",
                [
                    'required'      => false,
                    'data'          => $config[ChronopostConst::CHRONOPOST_SHIPPER_MOBILE_PHONE],
                    'label'         => Translator::getInstance()->trans("Mobile phone"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("0607080910")
                    ],
                ]
            )
            ->add(ChronopostConst::CHRONOPOST_SHIPPER_MAIL,
                "text",
                [
                    'required'      => true,
                    'data'          => $config[ChronopostConst::CHRONOPOST_SHIPPER_MAIL],
                    'label'         => Translator::getInstance()->trans("E-mail"),
                    'label_attr'    => [
                        'for'           => 'title',
                    ],
                    'attr'          => [
                        'placeholder'   => Translator::getInstance()->trans("jeandupont@gmail.com")
                    ],
                ]
            )

            /** BUILDFORM END */
        ;
    }

    public function getName()
    {
        return "chronopost_configuration_form";
    }
}