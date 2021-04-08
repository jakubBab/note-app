<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class TaskContext implements Context
{

    private string $token;
    private array $listOfTasks = [];
    private $task;
    private $response;
    private \GuzzleHttp\Client $client;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct($parameters)
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => $parameters['api_url']]);

    }

    /**
     * @Given I am an authenticated user  :arg1  :arg2
     */

    public function iAmAnAuthenticatedUser($arg1, $arg2)
    {

        $response = $this->client->post('/api/login_check', ['json' => [
            "username" => $arg1,
            "password" => $arg2
        ]]);

        if ($response->getStatusCode() != 200) {
            throw new Exception('unable to authenticate');
        }

        $content = json_decode($response->getBody()->getContents());
        $this->token = $content->token;
        return true;
    }

    /**
     * @When I add a task :arg1
     */
    public function iAddATask($arg1)
    {
        $response = $this->client->post('/api/task/create', ['headers' => [
            'Authorization' => "Bearer {$this->token}"
        ],
            'json' => ['description' => $arg1]
        ]);

        if ($response->getStatusCode() != 200) {
            throw new Exception('unable to add the task');
        }
        $this->task = json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @Then The result should include :arg1
     */
    public function theResultShouldInclude($arg1)
    {
        if (empty($this->listOfTasks)) {
            throw new Exception("List of tasks should include {$arg1}");
        }

        $sameDescriptionTasks = [];
        foreach ($this->listOfTasks as $task) {
            if ($task['description'] === $arg1) {
                $sameDescriptionTasks[] = $task;
            }
        }

        if (empty($sameDescriptionTasks)) {
            throw new Exception("List of tasks should include {$arg1}");

        }

        $this->task = end($sameDescriptionTasks);

    }


    /**
     * @When I request a list of tasks from :arg1
     */
    public function iRequestAListOfTasksFrom($arg1)
    {
        $listOfTasks = $this->client->get($arg1, ['headers' => [
            'Authorization' => "Bearer {$this->token}"
        ]]);

        if ($listOfTasks->getStatusCode() != 200) {
            throw new Exception('unable to fetch list of tokens for the user');
        }

        $this->listOfTasks = json_decode($listOfTasks->getBody()->getContents(), true);

    }


    /**
     * @Then task state should be :arg1
     */
    public function taskStateShouldBe($arg1)
    {

        $state = $arg1 == "true";
        if ($this->task['completed'] != $state) {
            throw new Exception("Task state should be  {$state} but is {$this->task['completed']}");
        }
    }

    /**
     * @When request is sent to :arg1 with completed :arg2
     */
    public function requestIsSentToWithCompleted($arg1, $arg2)
    {
        $this->response = $this->client->patch($arg1, ['headers' => [
            'Authorization' => "Bearer {$this->token}"
        ],
            'json' => ['completed' => (bool)$arg2, 'taskUuid' => $this->task['uuid']]
        ]);
    }

    /**
     * @Then I should get :arg1 response
     */
    public function iShouldGetResponse($arg1)
    {
        if ($this->response->getStatusCode() != $arg1) {
            throw new Exception('unable to add the task');
        }
    }

    /**
     * @Then Task should be completed as :arg1
     */
    public function taskShouldBeCompletedAs($arg1)

    {
        $task = $this->client->get("/api/task/{$this->task['uuid']}",
            ['headers' =>
                [
                    'Authorization' => "Bearer {$this->token}"
                ],
            ]);

        if ($task->getStatusCode() !== 200) {
            throw new Exception('unable to fetch the task');
        }

        $task = json_decode($task->getBody()->getContents(), true);

        if ($task['completed'] !== (bool)$arg1) {
            throw new Exception("task state should be {$arg1}");
        }
    }

}
