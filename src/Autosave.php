<?php

namespace Northrook\Storage;

enum Autosave
{
    case DISABLED;
    case ON_SHUTDOWN;
    case ON_DESTRUCTION;
}