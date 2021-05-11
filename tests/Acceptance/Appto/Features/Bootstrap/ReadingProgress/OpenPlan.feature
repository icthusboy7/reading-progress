@plan @open-plan
Feature: Open Plan
  In order to have a reading progress on the platform
  As a Reader
  I want to open a plan

  Scenario: A valid new Plan
    Given I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab" with body:
    """
    {
        "id": "e2ac1cbb-2004-4cab-a3eb-e208f0c6baab",
        "planId": "f24afe4a-50f7-4710-8eee-5370e5f8fc38",
        "readerId": "f50fca8d-2a55-4a3f-8fd2-2e07dcce33f6",
        "openDate": "2021-03-10T17:01:46+00:00"
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
      "startDate": null,
      "endDate": null,
      "devotionalReadings": []
    }
    """

  Scenario: A valid opened Plan
    Given I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab" with body:
    """
    {
        "id": "e2ac1cbb-2004-4cab-a3eb-e208f0c6baab",
        "planId": "f24afe4a-50f7-4710-8eee-5370e5f8fc38",
        "readerId": "f50fca8d-2a55-4a3f-8fd2-2e07dcce33f6",
        "openDate": "2021-03-11T17:01:46+00:00"
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
      "lastOpenedDate": "2021-03-11T17:01:46+00:00",
      "startDate": null,
      "endDate": null,
      "devotionalReadings": []
    }
    """

  Scenario: A duplicated Plan
    Given I send a PUT request to "/reading-progress/e97ec1dc-f799-4dcb-857f-800f7695c5cf" with body:
    """
    {
        "id": "e97ec1dc-f799-4dcb-857f-800f7695c5cf",
        "planId": "f24afe4a-50f7-4710-8eee-5370e5f8fc38",
        "readerId": "f50fca8d-2a55-4a3f-8fd2-2e07dcce33f6",
        "openDate": "2021-03-12T17:01:46+00:00"
    }
    """
    Then the response status code should be 409

  Scenario: can’t reopen before the last opened date
    Given I send a PUT request to "/reading-progress/e2ac1cbb-2004-4cab-a3eb-e208f0c6baab" with body:
    """
    {
        "id": "e2ac1cbb-2004-4cab-a3eb-e208f0c6baab",
        "planId": "f24afe4a-50f7-4710-8eee-5370e5f8fc38",
        "readerId": "f50fca8d-2a55-4a3f-8fd2-2e07dcce33f6",
        "openDate": "2021-03-09T17:01:46+00:00"
    }
    """
    Then the response status code should be 409

  Scenario: A distinct reading progress id
    Given I send a PUT request to "/reading-progress/2d030461-10cc-4d5c-b62f-7e32bdb52a8d" with body:
    """
    {
        "id": "e97ec1dc-f799-4dcb-857f-800f7695c5cf",
        "planId": "f24afe4a-50f7-4710-8eee-5370e5f8fc38",
        "readerId": "f50fca8d-2a55-4a3f-8fd2-2e07dcce33f6",
        "openDate": "2021-03-12T17:01:46+00:00"
    }
    """
    Then the response status code should be 400

  Scenario Outline: An invalid new Plan
    Given I send a PUT request to "/reading-progress/<id>" with body:
    """
    {
        "id": "<id>",
        "planId": <planId>,
        "readerId": <readerId>,
        "openDate": <openDate>
     }
    """
    Then the response status code should be 400
    Examples:
      | id                                   | planId                                 | readerId                               | openDate                    |
      | 1                                    | "8cc7e592-f519-46ff-85eb-928b43b38e23" | "895282a6-404d-46eb-ae50-7858a98c4d26" | "2021-03-10T17:01:46+00:00" |
      | true                                 | "8cc7e592-f519-46ff-85eb-928b43b38e23" | "895282a6-404d-46eb-ae50-7858a98c4d26" | "2021-03-10T17:01:46+00:00" |
      | 0                                    | "8cc7e592-f519-46ff-85eb-928b43b38e23" | "895282a6-404d-46eb-ae50-7858a98c4d26" | "2021-03-10T17:01:46+00:00" |
      | null                                 | "8cc7e592-f519-46ff-85eb-928b43b38e23" | "895282a6-404d-46eb-ae50-7858a98c4d26" | "2021-03-10T17:01:46+00:00" |
      | ''                                   | "8cc7e592-f519-46ff-85eb-928b43b38e23" | "895282a6-404d-46eb-ae50-7858a98c4d26" | "2021-03-10T17:01:46+00:00" |
      | text                                 | "8cc7e592-f519-46ff-85eb-928b43b38e23" | "895282a6-404d-46eb-ae50-7858a98c4d26" | "2021-03-10T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | 1                                      | "895282a6-404d-46eb-ae50-7858a98c4d26" | "2021-03-10T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | true                                   | "895282a6-404d-46eb-ae50-7858a98c4d26" | "2021-03-10T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | 0                                      | "895282a6-404d-46eb-ae50-7858a98c4d26" | "2021-03-10T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | null                                   | "895282a6-404d-46eb-ae50-7858a98c4d26" | "2021-03-10T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "''"                                   | "895282a6-404d-46eb-ae50-7858a98c4d26" | "2021-03-10T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "text"                                 | "895282a6-404d-46eb-ae50-7858a98c4d26" | "2021-03-10T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "895282a6-404d-46eb-ae50-7858a98c4d26" | 1                                      | "2021-03-10T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "895282a6-404d-46eb-ae50-7858a98c4d26" | true                                   | "2021-03-10T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "895282a6-404d-46eb-ae50-7858a98c4d26" | 0                                      | "2021-03-10T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "895282a6-404d-46eb-ae50-7858a98c4d26" | null                                   | "2021-03-10T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "895282a6-404d-46eb-ae50-7858a98c4d26" | "''"                                   | "2021-03-10T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "895282a6-404d-46eb-ae50-7858a98c4d26" | "text"                                 | "2021-03-10T17:01:46+00:00" |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "895282a6-404d-46eb-ae50-7858a98c4d26" | "895282a6-404d-46eb-ae50-7858a98c4d26" | 1                           |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "895282a6-404d-46eb-ae50-7858a98c4d26" | "895282a6-404d-46eb-ae50-7858a98c4d26" | true                        |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "895282a6-404d-46eb-ae50-7858a98c4d26" | "895282a6-404d-46eb-ae50-7858a98c4d26" | 0                           |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "895282a6-404d-46eb-ae50-7858a98c4d26" | "895282a6-404d-46eb-ae50-7858a98c4d26" | null                        |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "895282a6-404d-46eb-ae50-7858a98c4d26" | "895282a6-404d-46eb-ae50-7858a98c4d26" | "''"                        |
      | 8cc7e592-f519-46ff-85eb-928b43b38e23 | "895282a6-404d-46eb-ae50-7858a98c4d26" | "895282a6-404d-46eb-ae50-7858a98c4d26" | "text"                      |