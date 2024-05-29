#!/bin/bash

# GLOBAL VARIABLES
LOCATION="westeurope"
SITE_NAME="deutschetelekom"
PLAN_NAME="ServicePlan"
RESOURCE_GROUP="rg_deutschetelekom"
PHP_VERSION="8.3"
GITHUB_REPO=https://github.com/gabrirm/deutsche_telekom.git


# Log in to Azure using github secrets
az login --service-principal -u $AZ_CLIENT_ID -p $AZ_CLIENT_SECRET --tenant $AZ_TENANT_ID

# Create a resource group
az group create --name $RESOURCE_GROUP --location $LOCATION

# Create an App Service plan
az appservice plan create --name $PLAN_NAME --resource-group $RESOURCE_GROUP --location $LOCATION --is-linux --sku FREE

# Create webapp
az webapp create --name $SITE_NAME --resource-group $RESOURCE_GROUP --plan $PLAN_NAME  --deployment-source-url $GITHUB_REPO -b main --runtime "PHP|$PHP_VERSION"
az webapp config set --resource-group $RESOURCE_GROUP --name $SITE_NAME --php-version $PHP_VERSION 