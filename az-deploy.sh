#!/bin/bash

# GLOBAL VARIABLES
LOCATION="westeurope"
SITE_NAME="deutschetelekom"
RESOURCE_GROUP="rg_deutschetelekom"
REPO_URL="https://github.com/gabrirm/deutsche_telekom.git"


# Log in to Azure using github secrets
az login --service-principal -u $AZ_CLIENT_ID -p $AZ_CLIENT_SECRET --tenant $AZ_TENANT_ID

# Create a resource group
az group create --name $RESOURCE_GROUP --location $LOCATION

# Create webapp
az webapp up --name $SITE_NAME --resource-group $RESOURCE_GROUP --location $LOCATION --html