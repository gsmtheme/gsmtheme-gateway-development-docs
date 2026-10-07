# GSM Theme Payment Gateway Development Documentation

If your payment gateway verifies payments through a **browser callback**, please follow the **`YourGateway.php`** implementation as your reference.

If your payment gateway verifies payments through a **webhook callback**, please follow the **`YourGateway2.php`** implementation as your reference.

## Uploading Your Payment Gateway

After completing your payment gateway development, upload the gateway file to your hosting server through **File Manager**.

Navigate to the following directory:

```text
app > Services > Gateway
```

Place your payment gateway PHP file inside the **`Gateway`** directory.

For example:

```text
app/
└── Services/
    └── Gateway/
        ├── Bkash.php
        ├── GsmPay.php
        └── YourGateway.php
```

Make sure the gateway class and filename follow the same structure and conventions used by the existing gateway integrations.
