#!/bin/bash

# GLOBAL VARIABLES
LOCATION="westeurope"
SITE_NAME="deutschetelekom"
PLAN_NAME="ServicePlan"
RESOURCE_GROUP="rg_deutschetelekom"
PHP_VERSION="8.2"
BRANCH="main"


# Log in to Azure using github secrets
az login --service-principal -u $AZ_CLIENT_ID -p $AZ_CLIENT_SECRET --tenant $AZ_TENANT_ID

# Create a resource group
az group create --name $RESOURCE_GROUP --location $LOCATION

# Create an App Service plan

# Create webapp
az webapp up --name $SITE_NAME --resource-group $RESOURCE_GROUP --location $LOCATION --os-type=linux --runtime "PHP|$PHP_VERSION" 
az webapp deployment source config-local-git --name $SITE_NAME --resource-group $RESOURCE_GROUP
git remote add azure $(az webapp deployment source config-local-git --name $SITE_NAME --resource-group $RESOURCE_GROUP --query url --output tsv)
git push azure -u origin master
