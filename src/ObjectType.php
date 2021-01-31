<?php

namespace Cappa;


class ObjectType extends Enum
{
    public const Controller = 'controller';
    public const Command = 'command';
    public const Component = 'component';
    public const Other = 'other';
}