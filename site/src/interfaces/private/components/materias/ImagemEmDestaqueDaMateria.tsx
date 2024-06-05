import React, { useState } from "react";

const ImagemEmDestaqueDaMateria = () => {
    const [preview, setPreview] = useState<string | undefined>(undefined);

    const previewDaImagem = (event: React.ChangeEvent<HTMLInputElement>) => {
        const imagem = event.target.files?.[0];

        if(imagem){
            const fileReader = new FileReader();
            fileReader.onload = () => {
                setPreview(fileReader.result as string);
            }
            fileReader.readAsDataURL(imagem);
        }else{
            setPreview(undefined);
        }
    }

    return (
        <div>
            <span className="font-averta font-extrabold text-laranja text-lg uppercase italic">Imagem em destaque</span>
            <label htmlFor="imagem_destaque" className='bg-aurora h-64 flex items-center justify-center rounded-md cursor-pointer'>
                {preview ? 
                    <img src={preview} alt="Preview" className="h-full w-full object-cover rounded-md border-2 border-aurora bg-aurora" /> : 
                    <span className="font-averta font-extrabold uppercase italic text-azul-claro text-8xl pb-2.5">+</span>
                }
            </label>
            <input type="file" id="imagem_destaque" name="imagem_destaque" className="hidden" onChange={previewDaImagem}/>
        </div>
    );
}

export default ImagemEmDestaqueDaMateria;