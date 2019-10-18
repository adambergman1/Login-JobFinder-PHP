<?php

namespace login\view;

Interface View {
    public function response($isLoggedIn) : string;
}