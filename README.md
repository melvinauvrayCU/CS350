# RecipeBuddy - CS350 Project - Team LLMAO

Welcome to the GitHub repository of Team LLMAO's CS350 project: RecipeBuddy.

This repository is split into 3 parts:

- Our **website**, located inside the "website" folder
  - [website.cs350.melvinauvray.com](https://www.website.cs350.melvinauvray.com)
  - Written in HTML/CSS
- RecipeBuddy's **api**, located inside the "Backend" folder
  - [api.cs350.melvinauvray.com](https://www.api.cs350.melvinauvray.com)
  - Written in Laravel
- RecipeBuddy **webapp**, located inside the "Frontend" folder
  - [recipebuddy.cs350.melvinauvray.com](https://recipebuddy.cs350.melvinauvray.com)
  - Written in Vue.JS & TypeScript

## Contents

## Deployment system

This project contains a Github Actions script which deploy the project online.
The script is being run when changes are being made on **main** branch.

> Thus, when developing on another branch, only local testing will be available.

For website and backend, the script is simply copying all the files via ftp to the remote server.

For the frontend however, the script is compiling the Vue files by running `npm run build`. Only then it is sending the generated files via ftp to the remote server.

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
