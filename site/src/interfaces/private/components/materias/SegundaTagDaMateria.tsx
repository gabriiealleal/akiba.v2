const PrimeiraTagDaMateria = () => {
    return (
        <>
            <label htmlFor="segunda_tag" className="font-averta font-extrabold text-azul-claro text-lg uppercase text-center italic block">Segunda tag</label>
            <div className="relative">
                <select id="segunda_tag" name="segunda_tag" className="w-full rounded-md p-2 font-averta appearance-none pr-8 outline-none">
                    <option defaultValue="#"></option>
                    <option defaultValue="animes">Animes</option>
                    <option defaultValue="mangas">Mangás</option>
                    <option defaultValue="tops">Top's</option>
                    <option defaultValue="primeiras-impressoes">Primeiras impressões</option>
                    <option defaultValue="listas">Listas</option>
                    <option defaultValue="curiosidades">Curiosidades</option>
                </select>
                <div className="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <svg className="fill-current h-4 w-4 text-azul-claro" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                    </svg>
                </div>
            </div>
        </>
    );
}

export default PrimeiraTagDaMateria;