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

TODO
