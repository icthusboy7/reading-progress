@reading-progress @get-reading-progress
Feature: Get Reading Progress
  In order to have a reading progress on the platform
  As a Reader
  I want to get a Reading Progress of a plan

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
  Scenario: A valid opened reading progress plan
    When I send a "GET" request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab"
    Then the response status code should be 200
    And the response content should be:
    """
    {
      "id": "e2ac1cbb-2004-4cab-a3eb-e208f0c6baab",
      "planId": "f24afe4a-50f7-4710-8eee-5370e5f8fc38",
      "readerId": "f50fca8d-2a55-4a3f-8fd2-2e07dcce33f6",
      "lastOpenedDate": "2021-03-10T17:01:46+00:00",
      "startDate": null,
      "endDate": null,
      "devotionalReadings": []
    }
    """

  Scenario: A non existing reading progress plan
    When I send a "GET" request to "/reading-progress/e3ac1cbb-2004-4cab-a3eb-e208f0c6baab"
    Then the response status code should be 404

  Scenario Outline: An invalid reading progress plan
    Given I send a "GET" request to "/reading-progress/<id>"
    Then the response status code should be 400
    Examples:
      | id    |
      | 1     |
      | true  |
      | 0     |
      | null  |
      | ''    |
      | text  |