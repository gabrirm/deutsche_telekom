#!/bin/bash

# GLOBAL VARIABLES
LOCATION="westeurope"
SITE_NAME="deutschetelekom"
PLAN_NAME="ServicePlan"
RESOURCE_GROUP="rg_deutschetelekom"
PHP_VERSION="8.3"
GITHUB_REPO="https://github.com/gabrirm/deutsche_telekom.git"


# Log in to Azure using github secrets
az login --service-principal -u $AZ_CLIENT_ID -p $AZ_CLIENT_SECRET --tenant $AZ_TENANT_ID

# Create a resource group
az group create --name $RESOURCE_GROUP --location $LOCATION

# Create an App Service plan

# Create webapp
az webapp up --name $SITE_NAME --resource-group $RESOURCE_GROUP --location $LOCATION --os-type=linux --runtime "PHP|$PHP_VERSION" 
az webapp deployment source config --name $SITE_NAME --resource-group $RESOURCE_GROUP --repo-url $GITHUB_REPO --branch main --enable-cd true

