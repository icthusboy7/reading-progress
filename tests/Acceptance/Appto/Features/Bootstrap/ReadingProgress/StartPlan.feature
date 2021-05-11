@plan @start-plan
Feature: Start Plan
  In order to have a reading progress on the platform
  As a Reader
  I want to start a plan

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

  Scenario: can’t start before the last opened date
    Given I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/start" with body:
    """
      {
        "startDate": "2021-03-09T04:53:46+00:00"
      }
    """
    Then the response status code should be 409

  Scenario: A non started Plan
    Given I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/start" with body:
    """
      {
        "startDate": "2021-03-11T04:53:46+00:00"
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
      "endDate": null,
      "devotionalReadings": []
    }
    """

  Scenario: A non existing Plan
    Given I send a PUT request to "/reading-progress/e3ac1cbb-2004-4cab-a3eb-e208f0c6baab/start" with body:
    """
      {
        "startDate": "2021-03-11T04:53:46+00:00"
      }
    """
    Then the response status code should be 404

  Scenario: An started Plan
    Given I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/start" with body:
    """
      {
        "startDate": "2021-03-12T04:53:46+00:00"
      }
    """
    Then the response status code should be 409

  Scenario: A finished Plan
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
    Given I send a PUT request to "/reading-progress/28ad78d3-17ca-4381-9b48-aa1ce6c200ae/finish" with body:
    """
    {
        "finishDate": "2021-03-20T17:01:46+00:00"
    }
    """
    Given I send a PUT request to "/reading-progress/28ad78d3-17ca-4381-9b48-aa1ce6c200ae/start" with body:
    """
    {
      "startDate": "2021-03-21T04:53:46+00:00"
    }
    """
    Then the response status code should be 409

  Scenario Outline: An invalid reading progress start
    Given I send a PUT request to "/reading-progress/<id>/start" with body:
    """
      {
        "startDate": <startDate>
      }
    """
    Then the response status code should be 400
    Examples:
      | id                                   | startDate                   |
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