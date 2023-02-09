# RecipeBuddy - CS350 Project - Team LLMAO

Welcome to the GitHub repository of Team LLMAO's CS350 project: RecipeBuddy.

This repository is split into 3 parts:

- Our **website**, located inside the "website" folder
  - [website.cs350.melvinauvray.com](https://www.website.cs350.melvinauvray.com)
  - Written in HTML/CSS.
- RecipeBuddy's **api**, located inside the "Backend" folder
  - [api.cs350.melvinauvray.com](https://www.api.cs350.melvinauvray.com)
  - Written in Laravel.
- RecipeBuddy **webapp**, located inside the "Frontend" folder
  - [recipebuddy.cs350.melvinauvray.com](https://recipebuddy.cs350.melvinauvray.com)
  - Written in Vue.JS & TypeScript.

---

## Contents

1. [Deployment system](#deployment-system)
2. [Git usage](#git-usage)
   1. [Create a new branch](#create-a-new-branch)
   2. [Make changes](#make-changes)
   3. [Pull Request](#pull-request)
3. [Local testing](#local-testing)
   1. [Website](#website)
   2. [Backend](#backend)
   3. [Webapp](#webapp)

---

## Deployment system

This project contains a Github Actions script which deploy the project online.
The script is being run when changes are being made on **main** branch.

> Thus, when developing on another branch, only local testing will be available.

For website and backend, the script is simply copying all the files via ftp to the remote server.

For the frontend however, the script is compiling the Vue files by running `npm run build`. Only then it is sending the generated files via ftp to the remote server.

---

## Git usage

For this project, we will probably use the **Trunk-Based development**. You can find detailed informations about this here: [Trunk-based development](https://www.atlassian.com/continuous-delivery/continuous-integration/trunk-based-development)

To explain it quickly, our project will be based around the main branch, which will contain the latest stable version. Then, to develop new features, each member will create a separate branch which will contain the project + this new feature. This new branch will then be merged into the main branch when the feature is done.

> **To sum up**: We will have a main branch with a bunch of feature branches which will be created and merged into the main one after the development of new features.

### Create a new branch

In order to start the development of a new feature, we will first create a new **Issue** on GitHub. Make sure that the name of the issue is matching the name of the Trello card.
Also, be sure that the issue is assigned to yourself.

Then from this newly created issue, you should be able to find a button to create a new branch, which will be linked to this issue.

### Make changes

From VSCode, to make some changes on your branch, you first need to checkout on this branch. To do that, simply run these commands:

```bash
git fetch origin
git checkout the-branch-you-just-created
```

> The first line is to make sure that you are up to date with the remote repository.

> **Warning**: Before changing branch, make sure to push or discard all of your local changes, if any.

Then from this branch, you can make your changes and push them on Git.
To push on Git, you can run these following commands:

```bash
git add .
git commit -m "Comment on the modifications"
git push
```

> As said earlier, since you will not push the changes on the main branch, your changes will not appear online.

### Pull Request

When your feature is ready, you will need to merge your code with main branch so your feature will be part of the project.
To do that, you'll create a Pull request.
From GitHub, click on the **Pull requests** tab and click on **New pull request**.

Keep main as base branch and choose your branch for the compare section. Then, click on **Create pull request**.
Keep the same default name, but make sure to assign the pull request to yourself.

Then click again on create pull request.

Now that your Pull Request has been created, you can still make changes to your branch if you need it. When you're done, you'll need at least one **approval** by another member of the team in order to be able to merge your code into main.

To get the approval, assign another member as a reviewer from the right menu on the Pull Request.

The reviewer will review your code and eventually accept your changes. Now, you will be able to merge your feature on main by pressing the **Merge pull request** button on your Pull Request page.

This will push all of your code into main branch, and start the GitHub actions script we talked earlier.

---

## Local testing

You don't need to wait for your feature to be deployed online to test your code. Here is how you can see your changes in local.

### Website

For the website, simply open the **index.html** file in the website folder and the website should open in your web browser.

### Backend

#### Dependencies

You will need [Docker](https://www.docker.com/) installed on your computer.

#### Steps

Starting from the root path of the GitHub project on VSCode, open a terminal and navigate into the Backend folder:

```bash
cd Backend
```

From here, start the docker which will contain our project, the database and PhpMyAdmin:

```bash
docker-compose up
```

> **Note**: This may take a while the first time

The docker service should start, and you should be able to see the backend app in your web browser, at the address: [127.0.0.1](127.0.0.1).

In the docker, a MariaDB Database is present, credentials are the following:

```yml
MYSQL_ROOT_PASSWORD: "root"
MYSQL_USER: "admin"
MYSQL_PASSWORD: "root"
MYSQL_DATABASE: "recipebuddy"
```

In the docker, you will also have PhpMyAdmin installed, which is a tool used to see and interact with the Database manually. You can access PhpMyAdmin at the address: [127.0.0.1:8000](127.0.0.1:8000). To connect, you don't need to specify any server, and the user and password are given above.

To stop the docker from running, go back to the terminal and press `ctrl+C`

### Frontend

#### Dependencies

You will need [NodeJS](https://nodejs.org/en/download/) installed on your computer.

#### Steps

Starting from the root path of the GitHub project on VSCode, open a terminal and navigate into the Frontend folder:

```bash
cd Frontend
```

From here, if it's the first time you're doing this, you'll need to install the packages of the project. To do this, run:

```bash
npm ci
```

> **Note**: This may take a while the first time.

Now, before even starting making changes to the code, run:

```bash
npm run lint
```

This will permit to make some verification to your code while you're making updates, such as errors verification.

Then, in order to simply launch the app, run:

```bash
npm run dev
```

Now, the project should be accessible in your web browser, at the address given to you in the terminal.
In order to stop the service from running, simply press `ctrl+C`.
