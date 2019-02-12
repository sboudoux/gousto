
### Models and metadata

When using a relational database, Phalcon would normally map the model in memory generating a whole lot of metadata about keys, data types, PDO binding params...
From there, we can also generate model files using phalcon scaffolding tool to have models stubs to use / customise in your app.

When using metadata-based model, we can normally leverage that data and check attributes/columns accurately when writing sanitization & validation methods.
When using metadata-based model again, we can use this metadata to ensure the models contain the correct data when writing unit tests.

In this test, and because I have written a simple model class myself (time limited), validation, sanitization and tests are under my usual coding/quality standards.

Reference here:  https://docs.phalconphp.com/3.2/en/db-models-metadata




### NOTE - db structure

I have noticed the CSV data structure contains strings instead of IDs / foreign keys (cuisine, country, box_type)...
I assume that is specific to that test.

