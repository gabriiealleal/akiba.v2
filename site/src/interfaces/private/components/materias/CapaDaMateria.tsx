const CapaDaMateria = () => {
    return (
        <div>
            <span className="font-averta font-extrabold text-laranja text-lg uppercase italic block">Capa da matéria</span>
            <label htmlFor="capa_da_materia" className='bg-aurora h-52 flex items-center justify-center rounded-md cursor-pointer'>
                <span className="font-averta font-extrabold uppercase italic text-azul-claro text-8xl pb-2.5">+</span>
            </label>
            <input type="file" id="capa_da_materia" name="capa_da_materia" className="hidden"/>
        </div>
    );
}

export default CapaDaMateria;