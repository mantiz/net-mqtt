<?php

declare(strict_types=1);

namespace BinSoul\Test\Net\Mqtt\Packet;

use BinSoul\Net\Mqtt\Packet;
use BinSoul\Net\Mqtt\Packet\PublishCompletePacket;
use BinSoul\Net\Mqtt\PacketStream;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PublishCompletePacketTest extends TestCase
{
    private function getDefaultData(): string
    {
        return "\x70\x02\x00\x00";
    }

    public function test_getters_and_setters(): void
    {
        $packet = new PublishCompletePacket();
        $packet->setIdentifier(1);
        $this->assertEquals(1, $packet->getIdentifier());
    }

    public function test_cannot_set_negative_identifier(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $packet = new PublishCompletePacket();
        $packet->setIdentifier(-1);
    }

    public function test_cannot_set_too_large_identifier(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $packet = new PublishCompletePacket();
        $packet->setIdentifier(12345678);
    }

    public function test_write(): void
    {
        $packet = new PublishCompletePacket();
        $packet->setIdentifier(0);

        $stream = new PacketStream();
        $packet->write($stream);

        $this->assertEquals($this->getDefaultData(), $stream->getData());
    }

    public function test_read(): void
    {
        $stream = new PacketStream($this->getDefaultData());
        $packet = new PublishCompletePacket();
        $packet->read($stream);

        $this->assertEquals(Packet::TYPE_PUBCOMP, $packet->getPacketType());
    }
}