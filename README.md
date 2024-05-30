# Deutsche Telekom Project | Azure WebApp Deployment Using Github Actions

![Deutsche Telekom Logo](https://logos-download.com/wp-content/uploads/2016/11/Deutsche_Telekom_logo_pink.png)


## Project Overview

The project aims to deploy a basic static website on Azure, featuring a single HTML page that displays a personalized greeting message. The website is deployed using Github Actions CI/CD tools.

### Components

1. **index.html**: This file contains the HTML code for the website. It includes a placeholder `$GREETING_NAME` that will be replaced with a personalized name during deployment.

2. **chat.html**: Contains the HTML code for the ChatBot page.
   
3. **.github/workflows/az-deploy.yml**: Defines the CI/CD pipelines for Github. Contains the necessary commands to deploy to Azure.

4. **api/chat.php**: Implements the functionality to make a request to OpenAI API using gpt-3.5

5. **az-deploy.sh**: Shell script providing the functionality to create the necessary Azure resources using Azure CLI.

6. **phpinfo.php**: Provides information about the PHP environment.

### Usage Details

1. **Cloning Repository**: Clone the repository to a local machine using the provided repository URL.

2. **Configure Azure Credentials**: Ensure that Azure credentials are configured securely in the GitHub repository secrets. 

3. **Deployment Process**: Set up CI/CD pipelines using the provided .github/workflows YAML file.

4. **Accessing the Website**: Once the deployment is successful, the website can be accessed using the URL provided by Azure.

### Pipelines and Deployment information

When we push changes to this repository, this action acts a signal to our pipeline (defined in the az-deploy.yml file) and initiates a predefined sequence of tasks. Specifically, our pipeline respond to pushes made to the main or chat_feature branches.

A single job named build-and-deploy is designed to execute on a Ubuntu environment, executing several taks:
1. It feches the latest version of our codebase from Github. This process is known as repository checkout.
2. Once we have retrieved the code, our Azure WebApp deployment starts. During this task we use the sed command to replace placeholders with secrets (enrivonment variables) from Github. Then, our az-deploy.sh script is executed, creating the necessary Azure resources needed for a correct deployment.

Our pipeline automates the deployment of our application each time the code is pushed, which enhances reliability and maintains the integrity of our production environment.

### Note

I've implemented both optional features; however, I found that almost every LLM chatbot API requires some kind of paid subscription. I tried OpenAI API, but it requires tokens and a premium subscription. Then I searched for some info about free chatbot APIs and found HuggingFace models, but when making a request to their API, it resulted in an error saying that the model is too large: >16 GB. To solve this issue, you have to create a HuggingFace Space, which charges per resource usage.

Nonetheless, the whole functionality regarding code and API calls to OpenAI is implemented! (check chat.php and chat.html files)

