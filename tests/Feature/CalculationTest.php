<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalculationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_calculation()
    {
        $test_dates = [
            [
                "date_one" => "1/1/2021",
                "date_two" => "1/1/2022",
                "expected_result" => 365
            ],
            [
                "date_one" => "1/1/2021",
                "date_two" => "1/1/2021",
                "expected_result" => 0
            ],
            [
                "date_one" => "1/1/2022",
                "date_two" => "3/3/2021",
                "expected_result" => 304
            ],
            [
                "date_one" => "1/1/2022",
                "date_two" => "3/3/2001",
                "expected_result" => 7609
            ],
            [
                "date_one" => "1/19/1997",
                "date_two" => "1/1/2022",
                "expected_result" => 9113
            ],
            [
                "date_two" => "1/19/1997",
                "date_one" => "1/1/1985",
                "expected_result" => 4401
            ]
        ];
        foreach($test_dates as $test) {
            $response = $this->json('GET', '/api/calculate', 
                [
                    'date_one' => $test['date_one'],
                    'date_two' => $test['date_two']
                ]
            );
            $response->assertJsonPath('result', $test['expected_result']);
            $response->assertStatus(200);
            
        }
        
    }
}
