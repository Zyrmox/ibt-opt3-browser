<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserNavigationHistory 
{
    protected $disk = "navigation";
    
    public $history = array();
    
    private function userNavigationFileName() {
        $user = Auth::user();
        return sprintf("nav_%s_%s.json", str_replace(' ', '_', strtolower($user->name)), $user->id);
    }

    private function getFileContents() {
        $file = Storage::disk($this->disk)->get($this->userNavigationFileName());
        return json_decode($file);
    }

    private function saveHistoryToFile() {
        // $res = file_put_contents(Storage::disk($this->disk)->path($this->userNavigationFileName()), json_encode($this->history));
        Storage::disk($this->disk)->put($this->userNavigationFileName(), json_encode($this->history));
    }

    public function __construct()
    {
        if (!Storage::disk($this->disk)->exists($this->userNavigationFileName())) {
            $this->saveHistoryToFile();
        }
        
        $this->history = $this->getFileContents();
    }

    public function clear() {
        $this->history = array();
        $this->saveHistoryToFile();
    }

    public function push($url) {
        array_push($this->history, $url);
        $this->saveHistoryToFile();
    }
    
    /**
     * Returns last visited page URL
     *
     * @param  string $callback
     * @return string last visited URL
     */
    public function previous(string $callback): string {
        $last = end($this->history);
        if ($last == null) {
            return $callback;
        }
        return $last;
    }

    public function pop() {
        $res = array_pop($this->history);
        $this->saveHistoryToFile();
        return $res;
    }

    public function popUrl($url) {
        $index = array_search($url, $this->history);
        if (is_int($index)) {
            $popped = $this->history[$index];
            unset($this->history[$index]);
            $this->saveHistoryToFile();
            return $popped;
        }
        return null;
    }
}