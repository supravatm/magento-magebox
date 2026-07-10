# Voucher Payment for Adobe Commerce (Magento 2)

> A reference implementation of a custom voucher-based payment method for Adobe Commerce and Magento Open Source.

![Adobe Commerce](https://img.shields.io/badge/Adobe%20Commerce-2.4.x-blue)
![Magento Open Source](https://img.shields.io/badge/Magento%20Open%20Source-2.4.x-orange)
![PHP](https://img.shields.io/badge/PHP-8.1%2B-success)
![License](https://img.shields.io/badge/License-MIT-green)

## Overview

Voucher Payment is an open-source Adobe Commerce module that demonstrates modern Magento extension development through a complete voucher payment workflow.

The module combines checkout customization, service contracts, APIs, admin configuration, quote-to-order persistence, custom entities, and automated testing into a single cohesive implementation that can serve as both a development reference and a foundation for custom payment solutions.


---

## Key Features

### Checkout & Payment

- Custom Offline Payment Method
- Custom Checkout Payment Renderer
- Additional Checkout Payment Fields
- Voucher Number Validation
- Guest Checkout Support
- Customer Checkout Support
- Checkout Order Placement Validation

### Voucher Management

- Voucher Lifecycle Management
- Usage Limits
- Single-Use Voucher Support
- Voucher Expiration Handling
- Voucher Usage Tracking
- Order-Based Voucher Consumption

### Adobe Commerce Architecture

- Service Contracts
- Repository Pattern
- Extension Attributes
- Dependency Injection
- Plugins
- Observers
- Declarative Schema
- Data Interfaces

### APIs

- REST API Endpoints
- GraphQL Queries
- GraphQL Mutations
- Service Layer Integration

### Administration

- Admin Configuration
- ACL Permissions
- Admin UI Components
- Admin Order Information Blocks
- Logging and Diagnostics

### Quality & Testing

- Unit Tests
- Integration Tests
- Magento Coding Standards
- Production-Oriented Architecture

---

## Adobe Commerce Concepts Demonstrated

| Area | Feature |
|--------|--------|
| Payments | Custom Offline Payment Method |
| Checkout | Custom Payment Fields |
| Persistence | Quote-to-Order Data Transfer |
| Database | Declarative Schema & Custom Tables |
| APIs | REST & GraphQL |
| Backend | Admin Configuration |
| UI Components | Admin Forms & Grids |
| Architecture | Service Contracts & Repositories |
| Events | Observers & Plugins |
| Orders | Order Status Automation |
| Testing | Unit & Integration Testing |

---

## Use Cases

This repository can be used as:

- A custom payment method boilerplate
- A voucher or gift card solution starter
- A Magento checkout customization reference
- A service contract implementation example
- A REST API and GraphQL reference project
- A quote-to-order persistence example
- A Magento testing reference implementation
- A foundation for enterprise payment integrations

---

## Compatibility

| Component | Supported Version |
|------------|------------|
| Adobe Commerce | 2.4.x |
| Magento Open Source | 2.4.x |
| PHP | 8.1+ |

---

## Contributing

Contributions, improvements, and pull requests are welcome.

Before submitting a pull request, please ensure:

- Magento coding standards pass
- Unit tests pass
- Integration tests pass
- Documentation is updated where necessary

---

## License

This project is licensed under the MIT License.

See the LICENSE file for details.

---

## Disclaimer

This repository is intended as a reference implementation for Adobe Commerce and Magento Open Source developers. It demonstrates recommended extension development patterns and may be used as a foundation for custom payment and voucher-based solutions.