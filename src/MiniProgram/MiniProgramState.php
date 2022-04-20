<?php

namespace Zhineng\Bubble\MiniProgram;

enum MiniProgramState: string
{
    case Developer = 'developer';
    case Trial = 'trial';
    case Formal = 'formal';
}