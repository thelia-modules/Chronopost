# Chronopost

Allows you to choose between differents delivery modes offered by Chronopost.
Activating one or more of them will let your customers choose which one
they want.

Delivery types currently availables :

- Chrono13
- Fresh13
- Others will be added in future versions

NB1 : You need IDs provided by Chronopost to use this module.


## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is Chronopost.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/chronopost-module:~1.0
```

## Usage

First, go to your back office, tab Modules, and activate the module Chronopost.
Then go to Chronopost configuration page, tab "Advanced Configuration" and fill the required fields.

After activating the delivery types you wih to use, new tabs will appear. With these, you can
change the shipping prices according to the delivery type and the area, and/or activate free shipping for a given price and/or given area, or just
activate it no matter the are and cart amount.

To download labels without having to go on the directory in the server, use the "Export labels" tab and click on the save icon
when a label has been created.
Labels are automatically created when you put the order on the status ID you entered in the configuration form,
usually the treatment status.

## Loop

###[chronopost.check.rights]

Check if label directory is writable and readable.

### Input arguments

None

### Output arguments

|Variable   |Description |
|---        |--- |
|$ERRMES    | Error message |
|$ERRFILE   | Folder where the error has been detected |

### Exemple

```{loop name="yourloopname" type="chronopost.check.rights"}<!-- your template -->{/loop}```


###[chronopost.delivery.mode]

### Input arguments

None

### Output arguments

|Variable   |Description |
|---        |--- |
|$ID    | The delivery mode ID in the table |
|$TITLE    | The delivery mode title (ex : Fresh13) |
|$CODE    | The delivery mode code (ex : 2R) |
|$FREESHIPPING_ACTIVE    | 0 or 1 depending on whether the total freeshipping is active or not |
|$FREESHIPPING_FROM    | Cart price needed for freeshipping |

### Exemple

```{loop name="yourloopname" type="chronopost.delivery.mode"}<!-- your template -->{/loop}```

###[chronopost]

### Input arguments

|Argument |Description |
|---      |--- |
|**area_id** | **Mandatory** ID of the area from which you want to know the prices. |
|**delivery_mode_id** | **Mandatory** ID of the delivery mode of which you want to know the prices. |

### Output arguments

|Variable   |Description |
|---        |--- |
|$SLICE_ID    | ID of the price slice |
|$MAX_WEIGHT    | Max weight for this slice price |
|$MAX_PRICE    | Max untaxed price of a cart for this price |
|$PRICE    | Price for this slice |

### Exemple

```{loop name="chronopost" type="socolissimo"}<!-- your template -->{/loop}```

###[chronopost.area.freeshipping]

### Input arguments

|Argument |Description |
|---      |--- |
|**area_id** | ID of the area from which you want to know the free shipping minimum amount needed. |
|**delivery_mode_id** | ID of the delivery mode of which you want to know the free shipping minimum amount needed. |

### Output arguments

|Variable   |Description |
|---        |--- |
|$AREA_ID    | ID of the area |
|$DELIVERY_MODE_ID    | ID of the delivery mode |
|$CART_AMOUNT    | Cart amount needed for free shipping in this area and for this delivery mode |

### Exemple

```{loop name="chronopost.area.freeshipping" type="socolissimo"}<!-- your template -->{/loop}```

###[chronopost.export.label]

### Input arguments

|Argument |Description |
|---      |--- |
|**order_ref** | Reference of the order you want to display|
|**delivery_type** | Delivery type (ex Fresh13) of the orders you want to display |
|**delivery_code** | Delivery code (ex 2R) of the orders you want to display. |
|**label_number** | Label number of the order you want to display |
|**label_directory** | Label directory of the orders you want to display |

### Output arguments

|Variable   |Description |
|---        |--- |
|$REFERENCE    | Reference of the order |
|$DELIVERY_TYPE    | Delivery type of the order (ex Fresh13) |
|$DELIVERY_CODE    | Delivery code of the order (ex 2R) |
|$LABEL_NBR    | Label number of the order |
|$LABEL_DIR    | Label directory of the order |
|$ORDER_ID    | Order ID |

### Exemple

```{loop name="chronopost.area.freeshipping" type="socolissimo"}<!-- your template -->{/loop}```

##Integration

Templates are examples of integration for the default theme of Thelia and should probably be
modified to suit your website better.