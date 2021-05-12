<?php
/**
 * Livewire Component Controller - Side Menu
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Http\Livewire\Organisms;

use App\Models\DatabaseFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class SideMenu extends Component
{
    use WithFileUploads;

    public $path;
    public $file;
    public $iteration = 0;

    private $lastActiveTabSessionKey = 'lastActiveTab';
    public $default = 'insights';
    public $currentTab;
    public $currentUrl;

    public $files;

    const FILTER_ALL = -1;
    const FILTER_OWNING_FILES = 1;
    const FILTER_OTHERS_FILES = 2;

    public $search = '';
    public $filter = self::FILTER_ALL;
    protected $filterToggle = [
        self::FILTER_ALL => 'Všechny soubory',
        self::FILTER_OWNING_FILES => 'Mé soubory',
        self::FILTER_OTHERS_FILES => 'Soubory ostatních uživatelů',
    ];

    /**
     * Gets called on component mount
     *
     * @return void
     */
    public function mount(Request $request) {
        $this->path = $request->path();
        $this->fetchTabsData();
        $this->currentTab = session($this->lastActiveTabSessionKey, $this->default);
        $this->currentUrl = url()->current();
    }

    public function updatedFile() {
        $this->validate([
            'file' => 'required|file|max:128000|mimetypes:application/vnd.sqlite3,application/x-sqlite3', // 128MB max allowed file upload size
        ]);
    }

    public function save() {
        $this->validate([
            'file' => 'required|file|max:128000|mimetypes:application/vnd.sqlite3,application/x-sqlite3', // 128MB max allowed file upload size
        ]);

        $noDBFile = noDatabaseFileExists();
        $name = $this->file->store('', 'databases');

        $file = new DatabaseFile();
        $file->user()->associate(Auth::user());
        $file->url = $name;
        $file->original_name = $this->file->getClientOriginalName();

        $this->file = null;
        $this->iteration++;

        /**
         * Testing schema of uploaded database file for all tables
         */
        $file_saved = $this->validateUploadedDatabaseSchema($file);
        if ($file_saved == null) {
            return;
        }
        $this->fetchTabsData();

        if (currentTenantDBFile() == null && $noDBFile) {
            $this->switchDatabase($file);
            return redirect()->to($this->path);
        }
    }

    public function switchDatabase(DatabaseFile $database) {
        Auth::user()->changeDatabaseFile($database);
        return redirect()->to($this->path);
    }

    public function validateUploadedDatabaseSchema(DatabaseFile $database) {
        $required_tables = [
            "cProp", "JobInOperation", "JobResource", "Jobs", "LogOpts", "Materials",
            "MatEvents", "Ownership", "ResCalendar", "Resources", "VP",
        ];
        $database->makeCurrent();
        $schema = Schema::connection('tenant');
        foreach ($required_tables as $table) {
            if (!$schema->hasTable($table)) {
                // session()->flash('error', sprintf('Tabulka "%s" nebyla ve schématu nahrávané databáze nalezena!', $table));
                $this->addError('file', sprintf('Tabulka "%s" nebyla nalezena ve schématu nahrávaného databázového souboru.', $table));
                return null;
            }
        }
        
        return $database->save();
    }

    public function downloadDatabase(DatabaseFile $database) {
        return Storage::disk('databases')->download($database->url, $database->original_name);
    }

    public function deleteDatabase(DatabaseFile $database) {
        if ($database->isOwner()) {
            $database->delete();
            return redirect()->to($this->path);
        }
    }

    public function updatedSearch() {
        $this->fetchTabsData();
    }

    public function search() {
        $this->fetchTabsData();
    }

    public function updatedFilter() {
        $this->fetchTabsData();
    }

    public function changeSubMenu($menu) {
        $this->currentTab = $menu;
        $this->setLastActiveTab($menu);
        $this->fetchTabsData();
    }

    public function isCurrentTab($tabName) {
        return $this->currentTab == $tabName;
    }

    public function setLastActiveTab($tabName) {
        session([$this->lastActiveTabSessionKey => $tabName]);
    }

    public function fetchTabsData() {
        $query = DatabaseFile::where('original_name', 'like', '%' . $this->search . '%')->latest();
        switch ($this->filter) {
            case self::FILTER_OWNING_FILES:
                $query = $query->where('user_id', '=', Auth::id());
                break;
            case self::FILTER_OTHERS_FILES:
                $query = $query->where('user_id', '!=', Auth::id());
                break;
            case self::FILTER_ALL:
            default:
                break;
        }
        $this->files = $query->get();
    }

    public function render()
    {
        return view('livewire.organisms.side-menu', ["filterToggle" => $this->filterToggle]);
    }
}
