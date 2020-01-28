## requirement

- java13
- swagger-codegen

### ex

```
cd {swagger-codegen-home}
java -jar modules/swagger-codegen-cli/target/swagger-codegen-cli.jar generate -i {api-mock-path}/swagger.yaml -l nodejs-server -o {api-mock-path}/api-mock/app2/
``