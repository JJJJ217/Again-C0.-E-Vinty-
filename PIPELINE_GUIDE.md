# Azure DevOps Pipeline Guide - Individual Team Member Testing

This repository now contains individual testing pipelines for each team member, allowing you to run and monitor tests for specific people's work.

## 📁 Pipeline Files Overview

| Team Member | Pipeline File | Test Suite Name | Test Files |
|-------------|--------------|-----------------|------------|
| **Michael Sutjiato** | `azure-pipelines-michael.yml` | `Michael_Sutjiato_Tests` | • `Feature_Cart_ShoppingTest.php`<br>• `SmokeTest.php`<br>• `FunctionsTest.php` |
| **Jiaming Huang** | `azure-pipelines-jiaming.yml` | `Jiaming_Huang_Tests` | • `userAuthTest`<br>• `accountManagmentTest` |
| **Charlotte Pham** | `azure-pipelines-charlotte.yml` | `Charlotte_Pham_Tests` | • `profileManagementTest`<br>• `Feature_Products_CatalogTest.php` |
| **Thea Ngo** | `azure-pipelines-thea.yml` | `Thea_Ngo_Tests` | • `Feature_Products_CatalogTest.php` |
| **Baljinnyam Gansukh** | `azure-pipelines-baljinnyam.yml` | `Baljinnyam_Gansukh_Tests` | • `Feature_Inventory_ControlTest.php` |
| **All Members** | `azure-pipelines.yml` | All test suites | All test files (parallel execution) |

## 🚀 How to Set Up Individual Pipelines in Azure DevOps

### For Each Team Member:

1. **Go to Azure DevOps** → Your Project → Pipelines
2. **Click "New Pipeline"**
3. **Select "Azure Repos Git"** (or your source)
4. **Select your repository**
5. **Choose "Existing Azure Pipelines YAML file"**
6. **Select the appropriate pipeline file:**
   - For Michael: `/azure-pipelines-michael.yml`
   - For Jiaming: `/azure-pipelines-jiaming.yml`
   - For Charlotte: `/azure-pipelines-charlotte.yml`
   - For Thea: `/azure-pipelines-thea.yml`
   - For Baljinnyam: `/azure-pipelines-baljinnyam.yml`
7. **Click "Continue"** and then **"Run"**

### Rename Pipelines for Easy Identification:
- `Michael Sutjiato - Individual Tests`
- `Jiaming Huang - Individual Tests`
- `Charlotte Pham - Individual Tests`
- `Thea Ngo - Individual Tests`
- `Baljinnyam Gansukh - Individual Tests`

## 📊 Viewing Individual Test Results

After running a pipeline:

1. **Go to the pipeline run**
2. **Click on the "Tests" tab**
3. **View detailed results for that specific team member**
4. **Check the "Summary" tab for overall pipeline status**

## 🔧 Pipeline Features

Each individual pipeline includes:

- ✅ **Environment Setup**: PHP 8.1 configuration
- ✅ **Dependency Installation**: Composer packages
- ✅ **Pre-Test Validation**: Checks if test files exist
- ✅ **PHPUnit Configuration Validation**: Ensures test suites are properly configured
- ✅ **Test Execution**: Runs only that person's tests
- ✅ **Detailed Reporting**: JUnit XML results with coverage
- ✅ **Error Handling**: Continues even if tests fail
- ✅ **Result Publishing**: Individual test result dashboard

## 🎯 Usage Scenarios

### 1. **Individual Developer Testing**
Run a specific person's pipeline when:
- They push new code
- You want to verify their specific features
- Debugging issues in their test suite

### 2. **Team Review Process**
- Before code reviews, run the developer's individual pipeline
- Compare results between team members
- Identify which person's tests are failing

### 3. **Targeted Debugging**
- Focus on one person's failing tests
- Easier to identify who needs to fix what
- Cleaner error reporting per developer

## 📋 Manual Trigger Commands

Each pipeline is set to:
- **Trigger**: On pushes to `main` branch
- **PR**: Manual trigger only (`pr: none`)

This means you can run them manually without affecting the main pipeline.

## 🔍 Troubleshooting

### Common Issues:
1. **"No test result files found"**: Check if the test files exist in the `/tests/` directory
2. **"Unknown option"**: PHPUnit version issue - pipelines use PHPUnit 10.x compatible options
3. **"Cannot redeclare function"**: Fixed in `tests/bootstrap.php` with `function_exists()` checks

### Debug Steps:
1. Check the "Setup Test Environment" step to see if test files exist
2. Review the "Validate PHPUnit Setup" step for configuration issues
3. Look at the test execution logs for specific errors

## 📈 Next Steps

1. **Set up all individual pipelines** in Azure DevOps
2. **Test each pipeline** by running them manually
3. **Configure notifications** for each team member's pipeline
4. **Set up branch policies** to require passing individual tests before merging

---

**Happy Testing! 🧪✨**