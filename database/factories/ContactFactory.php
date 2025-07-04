<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'nome' => $this->faker->name,
            'telemovel' => $this->faker->numerify('9########'),
            'extensao' => $this->faker->optional()->numerify('####'),
            'funcionalidades' => $this->faker->text(50),
            'ativacao' => $this->faker->date(),
            'desativacao' => $this->faker->optional()->date(),
            'ticket_scmp' => $this->faker->optional()->bothify('TSCMP-####'),
            'ticket_fse' => $this->faker->optional()->bothify('TFSE-####'),
            'iccid' => $this->faker->optional()->numerify('89####################'),
            'equipamento' => $this->faker->word,
            'serial_number' => $this->faker->bothify('SN-#####'),
            'imei' => $this->faker->optional()->numerify('###############'),
            'obs' => $this->faker->optional()->sentence,
        ];
    }
}
