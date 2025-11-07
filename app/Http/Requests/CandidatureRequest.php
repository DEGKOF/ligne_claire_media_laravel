<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidatureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Accessible sans authentification
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'poste' => 'required|in:journaliste,redacteur',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max

            // La lettre de motivation peut être soit un texte, soit un fichier
            'lettre_motivation_texte' => 'nullable|string|max:5000',
            'lettre_motivation_fichier' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Au moins une lettre de motivation doit être fournie
            $texte = $this->input('lettre_motivation_texte');
            $fichier = $this->file('lettre_motivation_fichier');

            if (empty($texte) && !$fichier) {
                $validator->errors()->add(
                    'lettre_motivation',
                    'Veuillez fournir une lettre de motivation (texte ou fichier).'
                );
            }
        });
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'telephone.required' => 'Le numéro de téléphone est obligatoire.',
            'poste.required' => 'Veuillez sélectionner un poste.',
            'poste.in' => 'Le poste sélectionné n\'est pas valide.',
            'cv.required' => 'Le CV est obligatoire.',
            'cv.file' => 'Le CV doit être un fichier.',
            'cv.mimes' => 'Le CV doit être au format PDF, DOC ou DOCX.',
            'cv.max' => 'Le CV ne doit pas dépasser 5 Mo.',
            'lettre_motivation_texte.max' => 'La lettre de motivation ne doit pas dépasser 5000 caractères.',
            'lettre_motivation_fichier.file' => 'La lettre de motivation doit être un fichier.',
            'lettre_motivation_fichier.mimes' => 'La lettre de motivation doit être au format PDF, DOC ou DOCX.',
            'lettre_motivation_fichier.max' => 'La lettre de motivation ne doit pas dépasser 5 Mo.',
        ];
    }
}
