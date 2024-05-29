const TituloDaMeteria = () => {
    return (
        <div className="mb-6">
            <label htmlFor="titulo" className="font-averta font-extrabold text-laranja text-lg uppercase italic block">Título</label>
            <input type="text" id="titulo" name="titulo" className="w-full h-10 rounded-md pl-2 pr-2 outline-none font-averta" />
        </div>
    )
}

export default TituloDaMeteria;