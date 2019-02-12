
### Models and metadata

When using a relational database, Phalcon would normally map the model in memory generating a whole lot of metadata about keys, data types, PDO binding params...
From there, we can also generate model files using phalcon scaffolding tool to have models stubs to use / customise in your app.

When using metadata-based model, we can normally leverage that data and check attributes/columns accurately when writing sanitization & validation methods.
When using metadata-based model again, we can use this metadata to ensure the models contain the correct data when writing unit tests.

In this test, and because I have written a simple model class myself (time limited), validation, sanitization and tests are under my usual coding/quality standards.

Reference here:  https://docs.phalconphp.com/3.2/en/db-models-metadata



### Model setters/getters

Considering the fact that my database comes from a CSV file, I don;t have any informations regarding the data types.
As a result, I've created a sqlite database using 2 column types: integers and text. That sadly doesn't leave much room for doing anything interesting in terms of validation / sanitization.
So to save time, I've kept the model attributes private but added magic setters/getters to save time and avoid creating 25 setters/getters manually.

Validation is managed by the `validation()` method, and sanitization feature is virtually irrelevant for this project.



### NOTE - db structure

I have noticed the CSV data structure contains strings instead of IDs / foreign keys (cuisine, country, box_type)...
I assume that is specific to that test.

