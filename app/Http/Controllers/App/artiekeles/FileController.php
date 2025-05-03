<?php
namespace App\Http\Controllers\App\artiekeles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Artiekeles;

class FileController extends Controller
{
    public function uploadFile(Request $request)
    {
        if (!session('isLoggedIn')) {
            return redirect()->route('artieses')->with('alert', 'Harus login dulu.');
        }
        
        $judul = $request->input('judul');
        $kseo = $request->input('kseo');
        $lseo = $request->input('lseo');
        $request->validate([
            'file' => 'required|file|mimes:txt,pdf,docx'
        ]);
        $file = $request->file('file');
        $path = $file->storeAs('uploads', $file->getClientOriginalName());
        $extension = $file->getClientOriginalExtension();
        $text = '';
        $filePath = storage_path('app/private/' . $path);
        if ($extension == 'docx') {
            $text = $this->convertDocxToText($filePath);
        } elseif ($extension == 'pdf') {
            // $text = $this->convertPdfToText($filePath);
        } elseif ($extension == 'txt') {
            $text = file_get_contents($filePath);
        }
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        Artiekeles::create([
            'userid' => session('userid'),
            'judul' => $judul,
            'lseo' => $lseo,
            'kseo' => $kseo,
            'konten' => $text,
        ]);
        return redirect()->route('artieses')->with(['alert' => 'Artiekeles mu sudah di publish!']);
    }

    protected function convertDocxToText($filePath)
    {
        $username = session('username');
        $sofficePath = base_path('vendor/LibreOffice/program/soffice.exe');
        $outputDir = public_path("{$username}/artiekeles");

        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0755, true); // buat folder kalau belum ada
        }

        $fileName = pathinfo($filePath, PATHINFO_FILENAME);
        $outputHtmlPath = $outputDir . '/' . $fileName . '.html';

        $command = "$sofficePath --headless --convert-to html --outdir " . escapeshellarg($outputDir) . ' ' . escapeshellarg($filePath);
        shell_exec($command);

        $output = file_get_contents($outputHtmlPath);
        $output = preg_replace('/<p([^>]*)align="center"([^>]*)>/i', '<p$1style="text-align:center;"$2>', $output);

        $updatedOutput = preg_replace_callback('/<img\s+[^>]*src="([^"]+)"[^>]*>/i', function ($matches) use ($username) {
            $src = $matches[1];

            if (strpos($src, "{$username}/artiekeles/") === false) {
                $newSrc = "{$username}/artiekeles/" . $src;
                return str_replace($src, $newSrc, $matches[0]);
            }
            return $matches[0];
        }, $output);

        return $updatedOutput; // hanya return teks biasa
    }

    
//     protected function convertPdfToText($filePath)
// {
//     $pdftotextPath = base_path('vendor/xpdf-tools-win-4.05/bin64/pdftotext.exe'); 
//     $escapedFilePath = escapeshellarg($filePath);
//     $command = "\"$pdftotextPath\" $escapedFilePath -"; 
//     $output = shell_exec($command);
//     return $output ?: 'Gagal mengekstrak teks.';
// }


}
