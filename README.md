# DeepRent Developer Technical Assessment

<p align="center"><a href="https://deeprent.ai" target="_blank"><img src="https://deeprent.ai/wp-content/uploads/elementor/thumbs/cropped-cropped-DeepRent-Main-Logo-qozl2gl1om1seeuc24tj7qktf2lbegg2tmpje6wqj4.webp" width="400" alt="DeepRent Logo"></a></p>

## Table of Contents
1. [Position Overview](#position-overview)
2. [Application Process](#application-process)
   - [Environment Setup](#environment-setup)
   - [Screen Recording Tools](#screen-recording-tools)
   - [Submission Instructions](#submission-instructions)
3. [Technical Assessment Tasks](#technical-assessment-tasks)
   - [Basic Tasks (1 Point Each)](#basic-tasks-1-point-each)
   - [Intermediate Tasks (3 Points Each)](#intermediate-tasks-3-points-each)
   - [Advanced Tasks (5 Points Each)](#advanced-tasks-5-points-each)
4. [Example Data](#example-data)

## Position Overview

DeepRent is well-funded and is looking for extremely talented PHP/Laravel developers to help pioneer software that will make human Property Managers extinct.

You should be able to use Large Language Models (<a href="https://claude.ai"><img src="https://img.shields.io/badge/-Try%20Claude-7A56E3?logo=anthropic&logoColor=white" align="center"/></a>) to help build large and complex (yet maintainable) features in about one third the time that most competent people think possible.

Expect to work alongside talented, motivated, intense, and interesting co-workers.

We are an equal opportunity employer, this means:
- We don't care if you didn't go to university
- We don't care if you have worked as a PHP/Laravel developer before
- We don't care where you live and work from
- We don't care if you don't speak amazing English

**The only thing we care about is that you can produce exceptional code and we will pay you well for doing so.**
**We encourage you to use AI tools during your job and during the technical test below.**

## Application Process

1. Setup the environment
2. Start a screen recording
3. Complete as many technical tasks as you can
4. Submit your application to `apply@deeprent.ai`

Note: To complete all tasks, we expect it should take less than 2 hours.

### Environment Setup

1. Clone this repository
2. Configure a local PHP environment using Docker Desktop (<a href="https://www.docker.com/products/docker-desktop/"><img src="https://img.shields.io/badge/-Download%20Docker%20Desktop-2496ED?logo=docker&logoColor=white" align="center"/></a>) and MySQL
3. Follow instructions by LLMs

### Screen Recording Tools

**Mac Users:**
<a href="https://support.apple.com/guide/quicktime-player/record-your-screen-qtp97b08e666/mac">
  <img src="https://img.shields.io/badge/-For%20Mac%20Users:%20Use%20Quicktime%20Player-000000?logo=apple&logoColor=white"/>
</a>

**Windows Users:**
<a href="https://www.microsoft.com/en-us/windows/learning-center/how-to-record-screen-windows-11">
  <img src="https://img.shields.io/badge/-For%20Windows:%20Use%20The%20Game%20Bar-0078D4?logo=windows&logoColor=white"/>
</a>

### Submission Instructions

Email the following to `apply@deeprent.ai`

**Subject:** [POINT TOTAL] - [TIME SPENT ON TASKS] - [FULL NAME]

**Required Contents:**
1. Screen recording link (Google Drive or YouTube preferred)
2. What tasks were completed (in order of completion in the video)
3. Code package (ZIP format)
4. A good phone number we can text you at

## Technical Assessment Tasks

### Basic Tasks (1 Point Each)

#### 1. Success Notification Button
**Requirements:**
- Complete this task using the files called `success-notification-button.blade.php` / `SuccessNotificationButton.php`
- Create a button
- When the button is clicked it should show some form of loading animation
- After two seconds of loading, something that says "Success" should pop up on the screen

#### 2. Page Toggle
**Requirements:**
- Complete this task using the files called `page-toggle-one.blade.php` / `PageToggleOne.php` and `page-toggle-two.blade.php` / `PageToggleTwo.php`
- Make one page have a white background and the other have a black background
- Make a button that says "Make background dark" that navigates the user to the dark page from the light page
- Make a button that says "Make background light" that navigates the user to the light page from the dark page

#### 3. Metric Converter
**Requirements:**
- Complete this task using the files called `metric-converter.blade.php` / `MetricConverter.php`
- Make two input fields, one for feet and one for meters
- When typing into one input field have the other input field show the converted value (bidirectionally)
- Set appropriate decimal precision for the converted values
- Add input validation to prevent invalid number entries

#### 4. Unit Size Filter
**Requirements:**
- Complete this task using the files called `unit-size-filter.blade.php` / `UnitSizeFilter.php`
- Use the size options from `/example/unit-data.json`
- Create a dropdown menu for the different unit sizes 
- Whatever unit size is selected in the dropdown, display the unit data for that size to the user

### Intermediate Tasks (3 Points Each)

#### 5. Unit Data Table
**Requirements:**
- Complete this task using the files called `unit-data-table.blade.php` / `UnitDataTable.php`
- Create a table using provided test data from `/example/unit-data.json`
- Sort the table by the size of the unit (smallest to largest)
- Implement search functionality that matches search input to unit name

#### 6. Unit Model & Database
**Requirements:**
- Create a Unit model using laravel with fields for length (float), width (float), name (string), price (float), and status (string: "rented" or "available")
- Write database migrations to set up a "units" table with the proper columns for each field in the Unit model
- Add to the database seeder code that populates the database with test data from `/example/unit-data.json`

#### 7. Prorated Rent Calculator
**Requirements:**
- Complete this task using the files called `prorated-calculator.blade.php` / `ProratedCalculator.php`
- Create an interface where users can enter a move-in date and a monthly rent amount
- Calculate the prorated rent amount based on the chosen date using rules from `/example/proration-rules.json`
- Account for different month lengths and leap years in the calculation

### Advanced Tasks (5 Points Each)

#### 8. Unit Management CRUD Interface
**Requirements:**
- Complete this task using the files called `unit-management.blade.php` / `UnitManagement.php`
- Create an interface with the ability to Create, Read, Update, and Delete units listed in the table
- Ensure all alterations show up in the units table of the database

#### 9. Rent Increase Planning Tool
**Requirements:**
- Complete this task using the files called `rent-planning.blade.php` / `RentPlanning.php`
- Assume the property makes $3,000 in rent a month
- Create a line graph that shows a representation of the aggregate rent income throughout a year (e.g. January $3k, February $6k, etc.)
- Add functionality to have the user input how much rent they would like to make total throughout the year (e.g. $desiredRent = $50,000)
- Using the $desiredRent, calculate two evenly spaced rent raises from the current day to the end of the year that would result in this desired rent amount being reached
- Show two vertical lines for when the rent raises would be complete, and when you hover over the lines show by how much the rent would be raised (in percent form)
- Display monthly revenue projections based on the planned increases

## Example Data
All referenced example data files will be provided in the repository under the `example/` directory. Each file includes sample data structures and configuration options needed to complete the tasks.
