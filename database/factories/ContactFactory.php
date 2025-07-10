<?php /** @noinspection ALL */

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Factory to generate fake data for the Contact model.
 *
 * This is useful for seeding the database during development or testing.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    // Specify the model this factory is for
    protected $model = Contact::class;

    /**
     * Define the default state for a Contact instance.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Predefined options for "local" and "grupo" fields
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
