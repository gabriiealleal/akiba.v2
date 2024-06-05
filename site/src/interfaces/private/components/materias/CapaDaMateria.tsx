import React, { useState } from "react";

const CapaDaMateria = () => {
    const [preview, setPreview] = useState<string | undefined>(undefined);

    const previewDaImagem = (event: React.ChangeEvent<HTMLInputElement>) => {
        const imagem = event.target.files?.[0];

        if (imagem) {
            const fileReader = new FileReader();
            fileReader.onload = () => {
                setPreview(fileReader.result as string);
            }
            fileReader.readAsDataURL(imagem);
        } else {
            setPreview(undefined);
        }
    }
    return (
        <div className="mb-6">
            <span className="font-averta font-extrabold text-laranja text-lg uppercase italic block">Capa da matéria</span>
            <label htmlFor="capa_da_materia" className='bg-aurora h-72 flex items-center justify-center rounded-md cursor-pointer'>
                {preview ? 
                    <img src={preview} alt="Preview" className="h-full w-full object-cover rounded-md border-2 border-aurora bg-aurora" /> : 
                    <span className="font-averta font-extrabold uppercase italic text-azul-claro text-8xl pb-2.5">+</span>
                }            
            </label>
            <input type="file" id="capa_da_materia" name="capa_da_materia" className="hidden"  onChange={previewDaImagem} />
        </div>
    );
}

export default CapaDaMateria;