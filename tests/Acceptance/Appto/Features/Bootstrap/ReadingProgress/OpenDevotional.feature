@devotional @open-devotional
Feature: Open Devotional
  In order to have a reading progress on the platform
  As a Reader
  I want to open a devotional

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
    Given I send a PUT request to "/reading-progress/6d16293a-17d7-444a-b211-14380de14b35" with body:
    """
      {
          "id": "6d16293a-17d7-444a-b211-14380de14b35",
          "planId": "0b8db33a-da7c-49f4-9592-38cec2f81cf7",
          "readerId": "a7a4de22-85a8-49b2-96d8-81b94c1c9d8f",
          "openDate": "2021-03-15T17:01:46+00:00"
      }
    """

  Scenario: A valid new devotional
    When I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/devotionals/a17102c1-b979-492f-a74e-ea3d218e36e6/open" with body:
    """
    {
        "openDate": "2021-03-13T17:01:46+00:00"
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
      "devotionalReadings": {
          "a17102c1-b979-492f-a74e-ea3d218e36e6": {
              "devotionalId": "a17102c1-b979-492f-a74e-ea3d218e36e6",
              "lastOpenedDate": "2021-03-13T17:01:46+00:00",
              "readDate": null
          }
      }
    }
    """

  Scenario: Reopen an opened devotional
    When I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/devotionals/a17102c1-b979-492f-a74e-ea3d218e36e6/open" with body:
    """
    {
        "openDate": "2021-03-14T17:01:46+00:00"
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
      "devotionalReadings": {
          "a17102c1-b979-492f-a74e-ea3d218e36e6": {
              "devotionalId": "a17102c1-b979-492f-a74e-ea3d218e36e6",
              "lastOpenedDate": "2021-03-14T17:01:46+00:00",
              "readDate": null
          }
      }
    }
    """

  Scenario: can’t reopen before the last opened date
    When I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/devotionals/a17102c1-b979-492f-a74e-ea3d218e36e6/open" with body:
    """
    {
        "openDate": "2021-03-09T17:01:46+00:00"
    }
    """
    Then the response status code should be 409

  Scenario: A valid new devotional in unstarted plan
    When I send a PUT request to "/reading-progress/6d16293a-17d7-444a-b211-14380de14b35/devotionals/96a3685a-381d-4abf-8919-3d5b1812f7ea/open" with body:
    """
    {
        "openDate": "2021-03-17T17:01:46+00:00"
    }
    """
    Then the response status code should be 409

  Scenario: A non existing reading progress
    When I send a PUT request to "/reading-progress/3cd67e2f-c147-44c0-a780-35bce93eedb2/devotionals/a17102c1-b979-492f-a74e-ea3d218e36e6/open" with body:
    """
    {
        "openDate": "2021-03-12T17:01:46+00:00"
    }
    """
    Then the response status code should be 404

  Scenario Outline: An invalid open Devotional
    When I send a PUT request to "/reading-progress/<readingProgressId>/devotionals/<devotionalId>/open" with body:
    """
    {
        "openDate": <openDate>
    }
    """
    Then the response status code should be 400
    Examples:
      | readingProgressId                    | devotionalId                         | openDate                    |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | 8cc7e592-f519-46ff-85eb-928b43b38e23 | 1                           |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | 8cc7e592-f519-46ff-85eb-928b43b38e23 | true                        |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | 8cc7e592-f519-46ff-85eb-928b43b38e23 | 0                           |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | 8cc7e592-f519-46ff-85eb-928b43b38e23 | null                        |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "''"                        |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "text"                      |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | 1                                    | "2021-03-12T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | true                                 | "2021-03-12T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | 0                                    | "2021-03-12T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | null                                 | "2021-03-12T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | ''                                   | "2021-03-12T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | text                                 | "2021-03-12T17:01:46+00:00" |
      | 1                                    | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "2021-03-12T17:01:46+00:00" |
      | true                                 | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "2021-03-12T17:01:46+00:00" |
      | 0                                    | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "2021-03-12T17:01:46+00:00" |
      | null                                 | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "2021-03-12T17:01:46+00:00" |
      | ''                                   | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "2021-03-12T17:01:46+00:00" |
      | text                                 | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "2021-03-12T17:01:46+00:00" |