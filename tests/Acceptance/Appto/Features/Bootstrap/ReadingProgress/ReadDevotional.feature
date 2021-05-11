@devotional @read-devotional
Feature: Read Devotional
  In order to have a reading progress on the platform
  As a Reader
  I want to read a devotional

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

  Scenario: can’t read before the last opened date
    When I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/devotionals/a17102c1-b979-492f-a74e-ea3d218e36e6/read" with body:
    """
    {
        "readDate": "2021-03-15T18:01:46+00:00"
    }
    """
    Then the response status code should be 409

  Scenario: A valid read devotional
    When I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/devotionals/a17102c1-b979-492f-a74e-ea3d218e36e6/read" with body:
    """
    {
        "readDate": "2021-03-18T18:01:46+00:00"
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
              "lastOpenedDate": "2021-03-16T17:01:46+00:00",
              "readDate": "2021-03-18T18:01:46+00:00"
          }
      }
    }
    """

  Scenario: a read devotional
    When I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/devotionals/a17102c1-b979-492f-a74e-ea3d218e36e6/read" with body:
    """
    {
        "readDate": "2021-03-18T18:01:46+00:00"
    }
    """
    Then the response status code should be 409

  Scenario: A non existing reading progress
    When I send a PUT request to "/reading-progress/3cd67e2f-c147-44c0-a780-35bce93eedb2/devotionals/a17102c1-b979-492f-a74e-ea3d218e36e6/read" with body:
    """
    {
        "readDate": "2021-03-18T18:01:46+00:00"
    }
    """
    Then the response status code should be 404

  Scenario: A non existing devotional
    When I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab/devotionals/5d521db7-52b9-4473-9b87-910916163395/read" with body:
    """
    {
        "readDate": "2021-03-18T18:01:46+00:00"
    }
    """
    Then the response status code should be 404

  Scenario Outline: An invalid read Devotional
    When I send a PUT request to "/reading-progress/<readingProgressId>/devotionals/<devotionalId>/read" with body:
    """
    {
        "readDate": <readDate>
    }
    """
    Then the response status code should be 400
    Examples:
      | readingProgressId                    | devotionalId                         | readDate                    |
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