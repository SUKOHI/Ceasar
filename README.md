# Ceasar
A Laravel package to manage calendar easily.  
(This is for Laravel 5+. [For Laravel 4.2](https://github.com/SUKOHI/Ceasar/tree/1.0))

# Installation

Execute composer command.

    composer require sukohi/ceasar:2.*

Register the service provider in app.php

    'providers' => [
        ...Others...,  
        Sukohi\Ceasar\CeasarServiceProvider::class,
    ]

Also alias

    'aliases' => [
        ...Others...,  
        'Ceasar' => Sukohi\Ceasar\Facades\Ceasar::class,
    ]

# Usage

    $ceasar = \Ceasar::make('2016-5', $time_zone = null);
    $ceasar->firstDayOfWeek(0); // Optional: Which day is the first? 
    echo $ceasar->render(function($cal){

        if($cal->isStart) {

            $cal->view = '<table>';

        } else if($cal->isEnd) {

            $cal->view = '</table>';

        } else if($cal->isStartRow) {

            $cal->view = '<tr>';

        } else if($cal->isEndRow) {

            $cal->view = '</tr>';

        } else if($cal->isHeader) {

            $cal->view = '<td colspan="7">'. $cal->format('Y-m') .'</td>';

        } else if($cal->isDayOfWeek) {

            $cal->view = '<th>'. $cal->format('D') .'</th>';

        } else if($cal->isDay) {

            $cal->view = '<td>'. $cal->day .'</td>';

        } else if($cal->isEmpty) {

            $cal->view = '<td class="empty">'. $cal->day .'</td>';

        }

        return $cal;

    });

# About $cal

`$cal` is an instance of the class called Calendar which is extending Carbon.  
So you can use `$cal` as well as Carbon instance like so.

    if($cal->dayOfWeek == Carbon::SUNDAY) {

        $cal->view = '<td class="sunday">'. $cal->day .'</td>';

    } else if($cal->dayOfWeek == Carbon::SATURDAY) {

        $cal->view = '<td class="saturday">'. $cal->day .'</td>';

    } else {

        $cal->view = '<td>'. $cal->day .'</td>';

    }

# License

This package is licensed under the MIT License.

Copyright 2016 Sukohi Kuhoh