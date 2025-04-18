# Strativ_ProductTags Module for Magento 2

A custom Magento 2 module that allows adding tags to products and displaying them on the frontend.

## Features

- Add custom tags to products from the admin panel
- Display tags on the product detail page
- Allow customers to browse products by tag
- Admin interface for managing product tags
- Validation to prevent duplicate tags

## Installation

### Prerequisites

- Magento 2.4.x
- PHP 7.4 or higher
- Composer

### Setup Instructions

1. Clone the repository into `app/code/Strativ/ProductTags` directory:

   ```bash
   mkdir -p app/code/Strativ/ProductTags
   git clone https://github.com/amitkolloldey/magento2-product-tags.git app/code/Strativ/ProductTags
   ```

2. Enable the module:

   ```bash
   bin/magento module:enable Strativ_ProductTags
   bin/magento setup:upgrade
   bin/magento cache:clean
   bin/magento cache:flush
   ```

3. If in production mode, compile and deploy static content:

   ```bash
   bin/magento setup:di:compile
   bin/magento setup:static-content:deploy
   ```

## Usage

### Admin

1. Go to the product edit page in Magento admin
2. Find the "Strativ Tags" field in the product information
3. Add comma-separated tags to the product
4. Save the product

### Frontend

- Tags will appear on the product detail page
- Customers can click on tags to see all products with that tag
- Tag URLs follow the pattern: `/producttags/tag/view/tag/[tag-name]`

## Learning Experience

While creating this module for Magento 2, I learned:

1. **Magento 2 Module Architecture**: Understanding the modular structure and how to properly set up a module with appropriate XML configuration files.

2. **Database Operations**: Implementing a custom database table using declarative schema and properly interacting with the database using Resource Models and Collections.

3. **Dependency Injection**: Learning how Magento 2 handles dependency injection and how to properly define and use dependencies.

4. **Observer Pattern**: Implementing observers to react to system events, specifically the product save event to handle tags.

5. **Frontend Rendering**: Creating blocks, layouts, and templates to display tags on the frontend.

6. **UI Component System**: Integrating with Magento's UI Component system to customize the admin product edit form.

7. **MVC Architecture**: Understanding Magento's implementation of the Model-View-Controller architecture and routing system.

## Directory Structure & Code References

The directory structure for this module follows Magento 2's standard module architecture:

```
Strativ/ProductTags/
├── Block/                  # Block classes for frontend rendering
├── Controller/             # Controllers for frontend and admin actions
├── etc/                    # Configuration files
│   ├── adminhtml/          # Admin-specific configurations
│   ├── frontend/           # Frontend-specific configurations
│   ├── db_schema.xml       # Database schema
│   ├── events.xml          # Event observer configuration
│   └── module.xml          # Module declaration
├── Model/                  # Models and ResourceModels
│   ├── ProductTag.php      # Main model
│   └── ResourceModel/      # Resource models and collections
├── Observer/               # Event observers
├── Setup/                  # Installation and upgrade scripts
│   └── Patch/              # Data and schema patches
├── Ui/                     # UI Components
│   └── DataProvider/       # UI data providers
└── view/                   # Layout, templates, and UI components
    ├── adminhtml/          # Admin templates and layout
    │   ├── ui_component/   # UI Component configurations
    │   └── layout/         # Admin layouts
    └── frontend/           # Frontend templates and layout
        ├── layout/         # Frontend layout
        └── templates/      # Frontend templates
```

The code and structure were based on several specific resources:

1. **Claude AI**: Used for understanding module structure and basic concepts and debugging.
2. **Create UI Form in Magento 2** Webkul: UI Components (https://webkul.com/blog/create-ui-form-magento2-part-1/) for admin form integration.
3. **Max Pronko's "Custom UI Component in Magento 2"** tutorial: Followed his approach for implementing the product form field (https://www.youtube.com/watch?v=pQW_XUay52w).
4. **Magento 2 - UI Components Guide**: Used for understanding the structure of UI Components (https://devdocs.mage-os.org/docs/main/ui-components).
5. **studied the magento-2-product-tags repo"**: https://github.com/landofcoder/module-product-tags.
8. **Mark Shust's Docker Magento course** (https://m.academy/courses/magento-2-development-environment-docker/): Used for setting up the development environment.

## Challenges Faced

During the development of this module, I encountered several challenges:

1. **Dependency Injection Complexity**: Initially, I struggled with proper dependency injection in constructors, especially when multiple dependencies were required. I solved this by simplifying the number of dependencies and using the Object Manager for specific cases (though this is not generally recommended in Magento).

2. **UI Component Integration**: Adding custom fields to the product edit page proved challenging. I first attempted to use EAV attributes but later switched to UI Components for better flexibility and following best practices.

3. **Image Rendering**: Getting product images to display correctly on the tag listing page was difficult. I solved this by directly accessing the product's image attributes and using the store's media URL to construct the image path.

4. **Tag Validation**: Implementing validation to prevent duplicate tags required careful consideration of when and how to process the tags. I solved this by implementing case-insensitive comparison and deduplication in the observer that handles saving tags.

5. **Database Schema**: Understanding Magento's declarative schema approach took time. I had to learn how to properly define tables, columns, and constraints in a declarative manner.

6. **Frontend Routing**: Setting up the proper routes for tag pages required understanding Magento's routing system. I learned about route IDs, frontNames, and how to define controllers.

7. **Multiple Modules Integration**: Ensuring my module worked well with core Magento modules like Catalog required careful planning and testing.

## Debugging Techniques

When facing issues during development, I used several debugging techniques:

1. **Log Files**: Checking Magento's log files in `var/log/` (particularly `exception.log` and `system.log`) provided valuable error information.

2. **Xdebug Integration**: Setting up Xdebug with Mark Shust's Docker setup allowed for step-by-step debugging of complex code paths.

3. **Custom Debugging Controllers**: Creating controllers that output debug information helped diagnose issues like incorrect image paths or database queries.

4. **Database Inspection**: Directly inspecting the database structure and contents using phpMyAdmin helped verify that data was being stored correctly.



## Conclusion

Developing this Magento 2 module was a valuable learning experience that provided deep insights into Magento's architecture and best practices. The challenges encountered led to a better understanding of the framework and improved problem-solving skills. The end result is a functional and useful module that extends Magento's product tagging capabilities.