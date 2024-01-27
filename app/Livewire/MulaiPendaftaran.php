<?php

namespace App\Livewire;

use App\Models\Pendaftar;
use App\Models\Shop\Product;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\On;
use PhpParser\Node\Stmt\Label;
use Illuminate\Validation\ValidationException;
// use Illuminate\Auth\Events\Registered;

use function PHPUnit\Framework\isEmpty;

class MulaiPendaftaran extends Component implements HasForms
{
    use InteractsWithForms;


    public $username = '';
    public $password = 'vnPgyLdEKcLdeqPjnXHfHicgEXd3kRujdnWjTAbxpUe9tbvVLEa7VwefU7cLYYaNfxokn9jw9fqyp97gbMtw9TakscwmqhFCanj4jLVHTNXowzJzvPH9LeMeJXmpTJAkqu47pap9daPCLezahf9n3mTAwnbAyYjqpnprMvhmaJxncNsswqwhhFqvpvpUafpmismJEjtEMo9HYATyWars9qR9mKEtfwaez3M9NmmJHLb97mHhTLzARRaLaehg3TM';



    public function cek()
    {
        $user = User::where('username', $this->username);
dd($this->username);
        if($user !== null) {
            return redirect('/login')->with('username', $this->kk);
        } elseif ($user === null) {
                // $user = new user;
                // $user->name = 'a';
                // $user->username = $this->kk;
                // $user->password = Hash::make($this->password);
                // $user->panelrole = 'psbwalisantri';

                $user = User::create([
                    'name' => 'aaa',
                    'username' => $this->kk,
                    'password' => $this->password,
                    'panelrole' => 'psb',
                ]);
                Walisantri::create([
                    'user_id' => $user->id,
                ]);

                return $user;

                event(new Registered($user));

                Auth::login($user);

                return redirect('/psb');
        }
    }



    public function render(): View
    {
        return view('livewire.mulaipendaftaran');
    }
}
