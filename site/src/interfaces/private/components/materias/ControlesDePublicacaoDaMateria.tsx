const ControlesDePublicacaoDaMateria = () => {
    return (
        <div className="flex flex-wrap md:flex-nowrap justify-center gap-2 mt-12">
            <button className="border-4 border-verde pr-4 pl-4 pb-1 pt-1 rounded-xl font-averta font-extrabold italic text-xl text-verde uppercase">
                Salvar rascunho
            </button>
            <button className="border-4 border-laranja pr-4 pl-4 pb-1 pt-1 rounded-xl font-averta font-extrabold italic text-xl text-laranja uppercase">
                Mandar para revisão
            </button>
            <button className="border-4 border-azul-claro pr-4 pl-4 pb-1 pt-1 rounded-xl font-averta font-extrabold italic text-xl text-azul-claro uppercase">
                Publicar
            </button>
        </div>
    )
}

export default ControlesDePublicacaoDaMateria;