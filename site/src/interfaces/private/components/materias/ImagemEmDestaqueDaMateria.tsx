const ImagemEmDestaqueDaMateria = () => {
    return (
        <div>
            <span className="font-averta font-extrabold text-laranja text-lg uppercase italic">Imagem em destaque</span>
            <label htmlFor="imagem_destaque" className='bg-aurora h-64 flex items-center justify-center rounded-md cursor-pointer'>
                <span className="font-averta font-extrabold uppercase italic text-azul-claro text-8xl pb-2.5">+</span>
            </label>
            <input type="file" id="imagem_destaque" name="imagem_destaque" className="hidden"/>
        </div>
    );
}

export default ImagemEmDestaqueDaMateria;