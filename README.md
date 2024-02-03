# Magento 2 Store Locator Project

This project is a Magento 2 Store Locator module that allows users to find stores on a map, filter stores by categories, and search for specific stores. It's set up to run in a development environment using Warden, Docker, Elasticsearch, and Brew.

## Requirements

Before you begin, ensure you have met the following requirements:

- Docker and Docker Compose installed on your machine.
- Warden environment set up for Magento 2.
- Elasticsearch installed and configured.
- Homebrew installed (for macOS users).

## Installation

Follow these steps to get your development environment up and running:

1. **Navigate to your project directory:**

    ```sh
    cd store-locator-project
    ```

2. **Clone the project repository:**

    ```bash
    git clone git@github.com:Ehnvik/thesis-project-magento2.git
    ```

3. **Start the Warden environment:**

    ```sh
    warden env up
    ```

4. **Enable the Store Locator module:**

    ```sh
    bin/magento module:enable Gustav_Thesis
    ```

5. **Run Magento's setup upgrade script to install the module:**

    ```sh
    bin/magento setup:upgrade
    ```

6. **Clean the Magento cache to ensure your changes are reflected:**

    ```sh
    bin/magento cache:clean
    ```

## Accessing the Project

- **Frontend:** [https://app.store-locator-project.test/](https://app.store-locator-project.test/)
- **Admin Panel:** [https://app.store-locator-project.test/admin](https://app.store-locator-project.test/admin)
