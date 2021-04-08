Feature: Task

  Scenario:
    Given I am an authenticated user  "user@dockler.com"  "Johny123@!#"
    When I add a task "Behat task"
    When I request a list of tasks from "http://127.0.0.1:8081"
    Then The result should include "Behat task"

  Scenario:
    Given I am an authenticated user  "user@dockler.com"  "Johny123@!#"
    When I request a list of tasks from "http://127.0.0.1:8081"
    Then The result should include "Behat task"
    And task state should be "false"
    When request is sent to "/api/task/state" with completed "true"
    Then I should get "204" response
    And Task should be completed as "true"

  Scenario:
    Given I am an authenticated user  "user@dockler.com"  "Johny123@!#"
    When I request a list of tasks from "http://127.0.0.1:8081"
    Then The result should include "Behat task"
    And task state should be "true"
    When request is sent to "/api/task/state" with completed "false"
    Then I should get "204" response
    And Task should be completed as "false"