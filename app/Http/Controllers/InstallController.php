<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Setting;
use Exception;

class InstallController extends Controller
{
    public function index()
    {
        $requirements = [
            'PHP Version (>= 8.1)' => version_compare(PHP_VERSION, '8.1.0', '>='),
            'BCMath Extension' => extension_loaded('bcmath'),
            'Ctype Extension' => extension_loaded('ctype'),
            'JSON Extension' => extension_loaded('json'),
            'Mbstring Extension' => extension_loaded('mbstring'),
            'OpenSSL Extension' => extension_loaded('openssl'),
            'PDO Extension' => extension_loaded('pdo'),
            'Tokenizer Extension' => extension_loaded('tokenizer'),
            'XML Extension' => extension_loaded('xml'),
            'cURL Extension' => extension_loaded('curl'),
        ];
        
        $permissions = [
            'storage' => is_writable(storage_path()),
            'bootstrap/cache' => is_writable(base_path('bootstrap/cache')),
            '.env' => is_writable(base_path('.env')) || is_writable(base_path('.env.example')),
        ];
        
        $allRequirementsMet = !in_array(false, $requirements) && !in_array(false, $permissions);

        return view('install.step1', compact('requirements', 'permissions', 'allRequirementsMet'));
    }

    public function database()
    {
        return view('install.step2');
    }

    public function processDatabase(Request $request)
    {
        $request->validate([
            'db_host' => 'required|string',
            'db_port' => 'required|numeric',
            'db_database' => 'required|string',
            'db_username' => 'required|string',
            'db_password' => 'nullable|string',
        ]);

        // Test connection before saving
        try {
            $pdo = new \PDO(
                "mysql:host=" . $request->db_host . ";port=" . $request->db_port . ";dbname=" . $request->db_database,
                $request->db_username,
                $request->db_password,
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        } catch (Exception $e) {
            return back()->with('error', 'Koneksi database gagal: ' . $e->getMessage())->withInput();
        }

        // Save to .env
        $this->updateEnv([
            'DB_HOST' => $request->db_host,
            'DB_PORT' => $request->db_port,
            'DB_DATABASE' => $request->db_database,
            'DB_USERNAME' => $request->db_username,
            'DB_PASSWORD' => $request->db_password ?? '',
        ]);

        // Dynamically update config for this request
        config([
            'database.connections.mysql.host' => $request->db_host,
            'database.connections.mysql.port' => $request->db_port,
            'database.connections.mysql.database' => $request->db_database,
            'database.connections.mysql.username' => $request->db_username,
            'database.connections.mysql.password' => $request->db_password ?? '',
        ]);
        DB::purge('mysql');
        
        // Force reload config to make sure next step uses new DB
        Artisan::call('config:clear');

        // Migrate the database early so that sessions table exists for the next steps
        try {
            Artisan::call('migrate:fresh', ['--force' => true]);
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menjalankan migrasi: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('install.setup');
    }

    public function setup()
    {
        // Check if DB is connected properly
        try {
            DB::connection()->getPdo();
        } catch (Exception $e) {
            return redirect()->route('install.database')->with('error', 'Database belum terhubung. Pastikan kredensial benar.');
        }
        
        return view('install.step3');
    }

    public function processSetup(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'admin_name' => 'required|string|max:255',
            'admin_username' => 'required|string|max:255',
            'admin_password' => 'required|string|min:6',
        ]);

        try {
            // Generate Key
            Artisan::call('key:generate', ['--force' => true]);


            // Create Admin
            Admin::create([
                'name' => $request->admin_name,
                'username' => $request->admin_username,
                'email' => $request->admin_username . '@example.com',
                'password' => Hash::make($request->admin_password),
            ]);

            // Create Setting
            Setting::create([
                'app_name' => $request->app_name,
                'school_name' => 'Instansi Belum Diatur',
                'header_title' => 'LOGIN HAK PILIH',
                'election_title' => 'Pemilihan',
                'instructions' => 'Selamat datang.',
                'theme_color_1' => '#2db8a6',
                'theme_color_2' => '#1b8a7b',
                'theme_color_3' => '#f59e0b',
                'theme_color_4' => '#0f172a',
                'theme_color_5' => '#f59e0b',
                'theme_color_6' => '#d97706',
            ]);

            // Seed Dummy Data if requested
            if ($request->has('dummy_data')) {
                Artisan::call('db:seed', ['--class' => 'Database\Seeders\LegacyDataSeeder', '--force' => true]);
            }
            
            // Create installed file
            file_put_contents(storage_path('installed'), 'Installed at: ' . now());
            
            Artisan::call('optimize:clear');

            return redirect()->route('install.complete');
            
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat proses setup: ' . $e->getMessage())->withInput();
        }
    }

    public function complete()
    {
        if (!file_exists(storage_path('installed'))) {
            return redirect()->route('install.index');
        }
        return view('install.complete');
    }

    private function updateEnv($data)
    {
        $envPath = base_path('.env');
        
        if (!file_exists($envPath)) {
            if (file_exists(base_path('.env.example'))) {
                copy(base_path('.env.example'), $envPath);
            } else {
                touch($envPath);
            }
        }

        $envFile = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            $oldValue = env($key);
            
            // Handle values with spaces
            $value = str_contains($value, ' ') ? '"' . $value . '"' : $value;
            
            if (preg_match("/^{$key}=/m", $envFile)) {
                $envFile = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}={$value}",
                    $envFile
                );
            } else {
                $envFile .= "\n{$key}={$value}";
            }
        }

        file_put_contents($envPath, $envFile);
    }
}
