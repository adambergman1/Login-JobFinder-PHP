<?php

namespace login\view;

Interface View {
    public function response(bool $isLoggedIn) : string;
}