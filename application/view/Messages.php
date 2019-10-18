<?php

namespace application\view;

class Messages {
    const API_CONNECTION_ERROR = "Something went wrong when connecting to the API. Make sure that you have added the API-key to your environment variables.";
    const INVALID_KEYWORD_LENGTH = "Keyword is too short. Minimum 3 characters.";
    const INVALID_CITY_LENGTH = "City has too few characters. Minimum 3 characters.";
    const MISSING_KEYWORD = "Keyword is missing";
    const KEYWORD_AND_CITY_IS_INVALID = "Keyword is too short. Minimum 3 characters. <br> City has too few characters. Minimum 3 characters.";
}