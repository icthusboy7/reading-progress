@plan @finish-plan
Feature: Finish Devotional
  In order to have a reading progress on the platform
  As a Reader
  I want to finish a devotional

  Background:
    Given I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab" with body:
    """
      {
          "id": "e2ac1cbb-2004-4cab-a3eb-e208f0c6baab",
          "planId": "f24afe4a-50f7-4710-8eee-5370e5f8fc38",
          "readerId": "f50fca8d-2a55-4a3f-8fd2-2e07dcce33f6",
          "openDate": "2021-03-10T17:01:46+00:00"
      }
    """
    Given I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/start" with body:
    """
      {
        "startDate": "2021-03-11T04:53:46+00:00"
      }
    """
    Given I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/devotionals/a17102c1-b979-492f-a74e-ea3d218e36e6/open" with body:
    """
      {
          "openDate": "2021-03-16T17:01:46+00:00"
      }
    """
    Given I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/devotionals/addc5bfd-7ae1-45d8-9bdb-388d5cee1074/open" with body:
    """
      {
          "openDate": "2021-03-16T17:01:46+00:00"
      }
    """
    Given I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/devotionals/a17102c1-b979-492f-a74e-ea3d218e36e6/read" with body:
    """
      {
          "readDate": "2021-03-18T18:01:46+00:00"
      }
    """
    Given I send a PUT request to "/reading-progress/90993ebd-81a0-4ca2-9d12-a133b1b2346f" with body:
    """
      {
          "id": "90993ebd-81a0-4ca2-9d12-a133b1b2346f",
          "planId": "966b4dc0-b5e6-437e-98a4-275659fd39de",
          "readerId": "a2ac8951-1ea6-4072-99ae-0e35f11b383c",
          "openDate": "2021-03-10T17:01:46+00:00"
      }
    """
    Given I send a PUT request to "/reading-progress/28ad78d3-17ca-4381-9b48-aa1ce6c200ae" with body:
    """
      {
          "id": "28ad78d3-17ca-4381-9b48-aa1ce6c200ae",
          "planId": "ced62eae-b37e-4fb0-a5e3-3f9239c9f082",
          "readerId": "eb41d0ec-717a-4317-a825-195877166da6",
          "openDate": "2021-03-10T17:01:46+00:00"
      }
    """
    Given I send a PUT request to "/reading-progress/28ad78d3-17ca-4381-9b48-aa1ce6c200ae/start" with body:
    """
      {
        "startDate": "2021-03-11T04:53:46+00:00"
      }
    """
    Given I send a PUT request to "/reading-progress/28ad78d3-17ca-4381-9b48-aa1ce6c200ae/devotionals/8a132ffe-5a79-4a87-a8f4-4f4ea8aee72b/open" with body:
    """
      {
          "openDate": "2021-03-16T17:01:46+00:00"
      }
    """
    Given I send a PUT request to "/reading-progress/28ad78d3-17ca-4381-9b48-aa1ce6c200ae/devotionals/8a132ffe-5a79-4a87-a8f4-4f4ea8aee72b/read" with body:
    """
      {
          "readDate": "2021-03-18T18:01:46+00:00"
      }
    """
    Given I send a PUT request to "/reading-progress/7d5ffa0e-e541-4381-bfb1-08d3f6a5327c" with body:
    """
      {
          "id": "7d5ffa0e-e541-4381-bfb1-08d3f6a5327c",
          "planId": "776ec1af-f8df-41da-8691-0b4dd27b6a54",
          "readerId": "774a8855-fc22-443a-a931-4e8ba75022b5",
          "openDate": "2021-03-10T17:01:46+00:00"
      }
    """
    Given I send a PUT request to "/reading-progress/7d5ffa0e-e541-4381-bfb1-08d3f6a5327c/start" with body:
    """
      {
        "startDate": "2021-03-11T04:53:46+00:00"
      }
    """

  Scenario: Can`t finish if a devotional is not read
    When I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/finish" with body:
    """
    {
        "finishDate": "2021-03-20T18:01:46+00:00"
    }
    """
    Then the response status code should be 409

  Scenario: Can`t finish before read devotional
    When I send a PUT request to "/reading-progress/28ad78d3-17ca-4381-9b48-aa1ce6c200ae/finish" with body:
    """
    {
        "finishDate": "2021-03-17T17:01:46+00:00"
    }
    """
    Then the response status code should be 409

  Scenario: Can`t finish before start plan
    When I send a PUT request to "/reading-progress/90993ebd-81a0-4ca2-9d12-a133b1b2346f/finish" with body:
    """
    {
        "finishDate": "2021-03-20T18:01:46+00:00"
    }
    """
    Then the response status code should be 409

  Scenario: Can not finish a stared plan without devotionals
    When I send a PUT request to "/reading-progress/7d5ffa0e-e541-4381-bfb1-08d3f6a5327c/finish" with body:
    """
    {
        "finishDate": "2021-03-17T17:01:46+00:00"
    }
    """
    Then the response status code should be 409

  Scenario: A valid finish devotional
    Given I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/devotionals/addc5bfd-7ae1-45d8-9bdb-388d5cee1074/read" with body:
    """
      {
          "readDate": "2021-03-18T18:01:46+00:00"
      }
    """
    When I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/finish" with body:
    """
    {
        "finishDate": "2021-03-20T18:01:46+00:00"
    }
    """
    Then the response status code should be 204
    And the response should be empty
    When I send a "GET" request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab"
    Then the response status code should be 200
    And the response content should be:
    """
    {
      "id": "e2ac1cbb-2004-4cab-a3eb-e208f0c6baab",
      "planId": "f24afe4a-50f7-4710-8eee-5370e5f8fc38",
      "readerId": "f50fca8d-2a55-4a3f-8fd2-2e07dcce33f6",
      "lastOpenedDate": "2021-03-10T17:01:46+00:00",
      "startDate": "2021-03-11T04:53:46+00:00",
      "endDate": "2021-03-20T18:01:46+00:00",
      "devotionalReadings": {
          "a17102c1-b979-492f-a74e-ea3d218e36e6": {
              "devotionalId": "a17102c1-b979-492f-a74e-ea3d218e36e6",
              "lastOpenedDate": "2021-03-16T17:01:46+00:00",
              "readDate": "2021-03-18T18:01:46+00:00"
          },
          "addc5bfd-7ae1-45d8-9bdb-388d5cee1074": {
              "devotionalId": "addc5bfd-7ae1-45d8-9bdb-388d5cee1074",
              "lastOpenedDate": "2021-03-16T17:01:46+00:00",
              "readDate": "2021-03-18T18:01:46+00:00"
          }
      }
    }
    """

  Scenario: A non existing reading progress
    When I send a PUT request to "/reading-progress/c8539a05-d328-4977-8641-938343c972bf/devotionals/a17102c1-b979-492f-a74e-ea3d218e36e6/finish" with body:
    """
    {
        "readDate": "2021-03-18T18:01:46+00:00"
    }
    """
    Then the response status code should be 404

  Scenario Outline: An invalid reading progress finish
    Given I send a PUT request to "/reading-progress/<id>/finish" with body:
    """
      {
        "finishDate": <finishDate>
      }
    """
    Then the response status code should be 400
    Examples:
      | id                                   | finishDate                  |
      | fedcdd0e-e392-41d5-b60e-54f7813ffa05 | 1                           |
      | fedcdd0e-e392-41d5-b60e-54f7813ffa05 | true                        |
      | fedcdd0e-e392-41d5-b60e-54f7813ffa05 | 0                           |
      | fedcdd0e-e392-41d5-b60e-54f7813ffa05 | null                        |
      | fedcdd0e-e392-41d5-b60e-54f7813ffa05 | "''"                        |
      | fedcdd0e-e392-41d5-b60e-54f7813ffa05 | "text"                      |
      | 1                                    | "2021-03-11T04:53:46+00:00" |
      | true                                 | "2021-03-11T04:53:46+00:00" |
      | 0                                    | "2021-03-11T04:53:46+00:00" |
      | null                                 | "2021-03-11T04:53:46+00:00" |
      | ''                                   | "2021-03-11T04:53:46+00:00" |
      | text                                 | "2021-03-11T04:53:46+00:00" |