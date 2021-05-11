@reading-progress @list-reading-progress
Feature: List Reading Progress
  In order to have a reading progresses on the platform
  As a Reader
  I want to get a list Reading Progresses

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
    Given I send a PUT request to "/reading-progress/0036b4d2-efab-42f0-9e73-e0a715eb2674" with body:
    """
      {
          "id": "0036b4d2-efab-42f0-9e73-e0a715eb2674",
          "planId": "a259295c-a126-4d6e-9771-f920f76847dc",
          "readerId": "75bcdaf3-5e0b-4fba-a9aa-3430f12ec518",
          "openDate": "2021-03-12T19:01:50+00:00"
      }
    """
    Given I send a PUT request to "/reading-progress/5e7beb5d-ede9-4811-92a2-324c566f96de" with body:
    """
      {
          "id": "5e7beb5d-ede9-4811-92a2-324c566f96de",
          "planId": "a259295c-a126-4d6e-9771-f920f76847dc",
          "readerId": "6818b3db-b127-451a-87c9-957a3c8baf9b",
          "openDate": "2021-03-13T17:02:38+00:00"
      }
    """
    Given I send a PUT request to "/reading-progress/30910c11-f231-40af-805b-21132b611ed2" with body:
    """
      {
          "id": "30910c11-f231-40af-805b-21132b611ed2",
          "planId": "127956b6-d5cd-4a71-8ece-1a6c7e9bf2c6",
          "readerId": "6818b3db-b127-451a-87c9-957a3c8baf9b",
          "openDate": "2021-03-14T08:43:12+00:00"
      }
    """
  Scenario: Without filters
    When I send a "GET" request to "/reading-progress"
    Then the response status code should be 200
    And the response should has length 4

  Scenario: Filtered by valid PlanId and ReaderId
    When I send a "GET" request to "/reading-progress/?planId=f24afe4a-50f7-4710-8eee-5370e5f8fc38&readerId=f50fca8d-2a55-4a3f-8fd2-2e07dcce33f6"
    Then the response status code should be 200
    And the response should has length 1

  Scenario: Filtered by valid PlanId
    When I send a "GET" request to "/reading-progress/?planId=a259295c-a126-4d6e-9771-f920f76847dc"
    Then the response status code should be 200
    And the response should has length 2

  Scenario: Filtered by valid ReaderId
    When I send a "GET" request to "/reading-progress/?readerId=6818b3db-b127-451a-87c9-957a3c8baf9b"
    Then the response status code should be 200
    And the response should has length 2

  Scenario Outline: Get a Reading Progress with invalid filters
    When I send a "GET" request to "/reading-progress/?planId=<planId>&readerId=<readerId>"
    Then the response status code should be 400
    Examples:
      | planId                               | readerId                             |
      | 1                                    | 0036b4d2-efab-42f0-9e73-e0a715eb2674 |
      | true                                 | 0036b4d2-efab-42f0-9e73-e0a715eb2674 |
      | 0                                    | 0036b4d2-efab-42f0-9e73-e0a715eb2674 |
      | null                                 | 0036b4d2-efab-42f0-9e73-e0a715eb2674 |
      | ''                                   | 0036b4d2-efab-42f0-9e73-e0a715eb2674 |
      | text                                 | 0036b4d2-efab-42f0-9e73-e0a715eb2674 |
      | 0036b4d2-efab-42f0-9e73-e0a715eb2674 | 1                                    |
      | 0036b4d2-efab-42f0-9e73-e0a715eb2674 | true                                 |
      | 0036b4d2-efab-42f0-9e73-e0a715eb2674 | 0                                    |
      | 0036b4d2-efab-42f0-9e73-e0a715eb2674 | null                                 |
      | 0036b4d2-efab-42f0-9e73-e0a715eb2674 | ''                                   |
      | 0036b4d2-efab-42f0-9e73-e0a715eb2674 | text                                 |