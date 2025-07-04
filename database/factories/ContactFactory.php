<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

// Factory to fill the Contacts table with fake data
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        $locals = ['Hospital Prelada', 'Spec', 'Conde de Ferreira'];
        $grupos = ['DSI', 'OPS', 'Transporte'];

        return [
            'local' => $this->faker->randomElement($locals),
            'grupo' => $this->faker->randomElement($grupos),
            'nome' => Str::limit($this->faker->name, 30),
            'telemovel' => $this->faker->numerify('9########'),
            'extensao' => $this->faker->optional()->numerify('####'),
            'funcionalidades' => $this->faker->text(30),
            'ativacao' => $this->faker->date(),
            'desativacao' => $this->faker->optional()->date(),
            'ticket_scmp' => $this->faker->optional()->bothify('####'),
            'ticket_fse' => $this->faker->optional()->bothify('####'),
            'iccid' => $this->faker->optional()->numerify('89###################'),
            'equipamento' => Str::limit($this->faker->word, 30),
            'serial_number' => $this->faker->bothify('###########'),
            'imei' => $this->faker->optional()->numerify('###############'),
            'obs' => $this->faker->optional()->sentence,
        ];
    }
}
